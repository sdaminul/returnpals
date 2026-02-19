<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PackageItem extends Model
{
    protected $fillable = [
        'package_id',
        'product_name',
        'quantity',
        'condition',
        'notes',
    ];

    public function package(): BelongsTo
    {
        return $this->belongsTo(Package::class);
    }
}
