<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PertanyaanKuesioner extends Model
{
    protected $table = 'pertanyaan_kuesioner';

    protected $fillable = [
        'kuesioner_id',
        'pertanyaan',
        'tipe_jawaban',
        'opsi_jawaban',
    ];

    protected $casts = [
        'opsi_jawaban' => 'array',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Relationship: PertanyaanKuesioner belongs to Kuesioner
     */
    public function kuesioner(): BelongsTo
    {
        return $this->belongsTo(Kuesioner::class, 'kuesioner_id');
    }

    /**
     * Relationship: PertanyaanKuesioner has many JawabanKuesioner
     */
    public function jawaban(): HasMany
    {
        return $this->hasMany(JawabanKuesioner::class, 'pertanyaan_id');
    }
}
