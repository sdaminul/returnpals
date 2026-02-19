<?php

namespace App\Support;

class BulkPackageParser
{
    /**
     * Parse CSV/XLSX into packages.
     *
     * Output shape:
     *  [
     *    'packages' => [
     *      ['reference' => 'PKG-001', 'notes' => '...', 'items' => [...]],
     *    ],
     *    'summary' => ['package_count' => 3, 'item_count' => 6]
     *  ]
     */
    public static function parse(string $path, ?string $ext = null): array
    {
        $ext = strtolower((string)$ext);
        $rows = [];

        if ($ext === 'csv' || $ext === 'txt') {
            $rows = self::readCsv($path);
        } elseif ($ext === 'xlsx') {
            $rows = SimpleXlsxReader::readFirstSheet($path);
        } else {
            throw new \RuntimeException('Unsupported file type.');
        }

        // Find header row (first row containing at least 2 text headers)
        $headerRowIndex = null;
        foreach ($rows as $i => $r) {
            $nonEmpty = array_values(array_filter(array_map(fn ($v) => trim((string)$v), $r), fn ($v) => $v !== ''));
            if (count($nonEmpty) >= 2) {
                $headerRowIndex = $i;
                break;
            }
        }
        if ($headerRowIndex === null) {
            return ['packages' => [], 'summary' => ['package_count' => 0, 'item_count' => 0]];
        }

        $headers = array_map([self::class, 'normHeader'], $rows[$headerRowIndex]);
        $map = self::mapHeaders($headers);

        $packages = [];
        // If reference is blank in the file, we auto-generate:
        // AUTO-<TOKEN>-<N> (N increments per blank reference row)
        $autoToken = self::makeAutoToken();
        $autoCounter = 1;

        for ($i = $headerRowIndex + 1; $i < count($rows); $i++) {
            $row = $rows[$i];
            $ref = trim(self::cell($row, $map['reference']));
            if ($ref === '') {
                $ref = 'AUTO-' . $autoToken . '-' . $autoCounter;
                $autoCounter++;
            }

            $product = trim(self::cell($row, $map['product_name']));
            $qtyRaw = self::cell($row, $map['quantity']);
            $condition = trim(self::cell($row, $map['condition']));
            $itemNotes = trim(self::cell($row, $map['item_notes']));
            $pkgNotes = trim(self::cell($row, $map['package_notes']));

            if ($product === '') {
                // Skip rows without an item name
                continue;
            }

            $qty = (int)preg_replace('/[^0-9]/', '', (string)$qtyRaw);
            if ($qty < 1) $qty = 1;

            if ($condition === '') $condition = 'New';
            $condition = self::normalizeCondition($condition);

            if (!isset($packages[$ref])) {
                $packages[$ref] = [
                    'reference' => $ref,
                    'notes' => $pkgNotes !== '' ? $pkgNotes : null,
                    'items' => [],
                ];
            } else {
                if (($packages[$ref]['notes'] ?? null) === null && $pkgNotes !== '') {
                    $packages[$ref]['notes'] = $pkgNotes;
                }
            }

            $packages[$ref]['items'][] = [
                'product_name' => $product,
                'quantity' => $qty,
                'condition' => $condition,
                'notes' => $itemNotes !== '' ? $itemNotes : null,
            ];
        }

        $packagesList = array_values($packages);
        $itemCount = 0;
        foreach ($packagesList as $p) {
            $itemCount += count($p['items'] ?? []);
        }

        return [
            'packages' => $packagesList,
            'summary' => [
                'package_count' => count($packagesList),
                'item_count' => $itemCount,
            ],
        ];
    }

    private static function readCsv(string $path): array
    {
        $rows = [];
        $handle = fopen($path, 'r');
        if (!$handle) {
            throw new \RuntimeException('Unable to open CSV file.');
        }

        // Try to detect delimiter
        $firstLine = fgets($handle);
        if ($firstLine === false) {
            fclose($handle);
            return [];
        }
        $delimiter = (substr_count($firstLine, ';') > substr_count($firstLine, ',')) ? ';' : ',';
        rewind($handle);

        while (($data = fgetcsv($handle, 0, $delimiter)) !== false) {
            $rows[] = array_map(fn ($v) => is_string($v) ? trim($v) : (string)$v, $data);
        }
        fclose($handle);
        return $rows;
    }

    private static function normHeader($h): string
    {
        $h = strtolower(trim((string)$h));
        $h = str_replace(['-', '.', '(', ')', '/'], ' ', $h);
        $h = preg_replace('/\s+/', ' ', $h);
        return $h;
    }

    private static function mapHeaders(array $headers): array
    {
        $find = function (array $needles) use ($headers) {
            foreach ($headers as $i => $h) {
                foreach ($needles as $n) {
                    if ($h === $n) return $i;
                    if (str_contains($h, $n)) return $i;
                }
            }
            return null;
        };

        return [
            'reference' => $find(['package reference', 'reference', 'tracking number', 'tracking', 'package id']) ?? 0,

            'product_name' => $find(['item name', 'product name', 'product', 'sku']) ?? 1,

            'quantity' => $find(['qty', 'quantity', 'count']) ?? 2,

            'condition' => $find(['condition', 'grade', 'status']) ?? 3,

            // 🔥 IMPORTANT FIX HERE
            // If header is just "Notes", treat it as PACKAGE notes
            'package_notes' => $find(['package notes', 'package note', 'notes']) ?? null,

            // Item notes must explicitly contain "item"
            'item_notes' => $find(['item notes', 'item note']) ?? null,
        ];
    }


    private static function cell(array $row, ?int $idx): string
    {
        if ($idx === null) return '';
        return isset($row[$idx]) ? (string)$row[$idx] : '';
    }

    private static function normalizeCondition(string $condition): string
    {
        $c = strtolower(trim($condition));
        if ($c === 'used' || $c === 'pre-owned' || $c === 'preowned') return 'Used';
        if ($c === 'new' || $c === 'sealed') return 'New';
        if ($c === 'return' || $c === 'returned') return 'Return';
        if ($c === 'return review' || $c === 'review' || $c === 'return-review') return 'Return Review';
        // fallback: title case
        return ucwords($condition);
    }

    private static function makeAutoToken(): string
    {
        // 8-ish chars, uppercase, file-specific
        // Example output: MLRLFDB2
        try {
            $bytes = random_bytes(5);
            $hex = bin2hex($bytes);
        } catch (\Throwable $e) {
            $hex = bin2hex((string) microtime(true));
        }

        $raw = strtoupper(preg_replace('/[^A-Z0-9]/', '', base_convert($hex, 16, 36)));
        $raw = str_pad($raw, 8, 'A');
        return substr($raw, 0, 8);
    }
}
