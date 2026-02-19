<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SoldItem extends Model
{
    protected $fillable = [
        'user_id',
        'reference',
        'product_name',
        'quantity',
        'unit_price',
        'total_revenue',
        'profit',
        'margin',
        'sold_at',
        'status',
    ];

    protected $casts = [
        'sold_at' => 'date',
        'unit_price' => 'decimal:2',
        'total_revenue' => 'decimal:2',
        'profit' => 'decimal:2',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
