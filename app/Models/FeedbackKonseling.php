<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FeedbackKonseling extends Model
{
    protected $table = 'feedback_konseling';

    protected $fillable = [
        'konseling_id',
        'rating',
        'komentar',
    ];

    protected $casts = [
        'rating' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Relationship: FeedbackKonseling belongs to Konseling
     */
    public function konseling(): BelongsTo
    {
        return $this->belongsTo(Konseling::class, 'konseling_id');
    }
}
