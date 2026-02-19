<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PendingItem extends Model
{
    protected $fillable = [
        'user_id',
        'reference',
        'product_name',
        'quantity',
        'received_at',
        'stage',
        'est_completion',
        'note',
    ];

    protected $casts = [
        'received_at' => 'date',
        'est_completion' => 'date',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
