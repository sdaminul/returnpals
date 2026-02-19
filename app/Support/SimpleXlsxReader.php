<?php

namespace App\Support;

use ZipArchive;

/**
 * Tiny XLSX reader (first sheet only) without external libraries.
 * Supports shared strings + inline strings + numeric cells.
 */
class SimpleXlsxReader
{
    /**
     * @return array<int, array<int, string>> Rows as arrays of cell values.
     */
    public static function readFirstSheet(string $path): array
    {
        $zip = new ZipArchive();
        if ($zip->open($path) !== true) {
            throw new \RuntimeException('Unable to open XLSX file.');
        }

        $sharedStrings = [];
        $sharedXml = $zip->getFromName('xl/sharedStrings.xml');
        if ($sharedXml) {
            $sx = @simplexml_load_string($sharedXml);
            if ($sx) {
                foreach ($sx->si as $si) {
                    // Handle rich text runs <r><t>
                    if (isset($si->t)) {
                        $sharedStrings[] = (string)$si->t;
                    } else {
                        $text = '';
                        foreach ($si->r as $run) {
                            $text .= (string)($run->t ?? '');
                        }
                        $sharedStrings[] = $text;
                    }
                }
            }
        }

        $sheetXml = $zip->getFromName('xl/worksheets/sheet1.xml');
        if (!$sheetXml) {
            // fallback: find any sheet
            for ($i = 1; $i <= 5; $i++) {
                $sheetXml = $zip->getFromName("xl/worksheets/sheet{$i}.xml");
                if ($sheetXml) break;
            }
        }
        if (!$sheetXml) {
            $zip->close();
            throw new \RuntimeException('Unable to read worksheet from XLSX file.');
        }

        $sx = @simplexml_load_string($sheetXml);
        if (!$sx) {
            $zip->close();
            throw new \RuntimeException('Invalid worksheet XML.');
        }

        $rows = [];
        $namespaces = $sx->getNamespaces(true);
        // Ensure we can read nodes even with namespaces
        if (!empty($namespaces)) {
            foreach ($namespaces as $prefix => $ns) {
                $sx->registerXPathNamespace($prefix ?: 'x', $ns);
            }
        }

        $sheetData = $sx->sheetData ?? null;
        if (!$sheetData) {
            $zip->close();
            return [];
        }

        foreach ($sheetData->row as $row) {
            $cells = [];
            foreach ($row->c as $c) {
                $r = (string)$c['r'];
                $col = self::colIndex($r);
                $type = (string)($c['t'] ?? '');

                $value = '';
                if ($type === 's') {
                    $idx = (int)($c->v ?? 0);
                    $value = $sharedStrings[$idx] ?? '';
                } elseif ($type === 'inlineStr') {
                    $value = (string)($c->is->t ?? '');
                } else {
                    $value = (string)($c->v ?? '');
                }
                $cells[$col] = trim($value);
            }

            if (!empty($cells)) {
                $max = max(array_keys($cells));
                $out = [];
                for ($i = 0; $i <= $max; $i++) {
                    $out[] = $cells[$i] ?? '';
                }
                $rows[] = $out;
            }
        }

        $zip->close();
        return $rows;
    }

    private static function colIndex(string $cellRef): int
    {
        // Example: A1, AB12
        if (!preg_match('/^([A-Z]+)/', strtoupper($cellRef), $m)) {
            return 0;
        }
        $letters = $m[1];
        $num = 0;
        for ($i = 0; $i < strlen($letters); $i++) {
            $num = $num * 26 + (ord($letters[$i]) - 64);
        }
        return $num - 1;
    }
}
