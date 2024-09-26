<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Expense extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'description',
        'date',
        'user_id',
        'amount',
    ];

    // Relationship with User (1:1)
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
