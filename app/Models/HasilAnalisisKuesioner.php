<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HasilAnalisisKuesioner extends Model
{
    protected $table = 'hasil_analisis_kuesioner';

    protected $fillable = [
        'kuesioner_id',
        'summary',
        'insights',
    ];

    protected $casts = [
        'insights' => 'array',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Relationship: HasilAnalisisKuesioner belongs to Kuesioner
     */
    public function kuesioner(): BelongsTo
    {
        return $this->belongsTo(Kuesioner::class, 'kuesioner_id');
    }
}
