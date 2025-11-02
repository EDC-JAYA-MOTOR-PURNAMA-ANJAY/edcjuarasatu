<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class JawabanKuesioner extends Model
{
    protected $table = 'jawaban_kuesioner';

    protected $fillable = [
        'kuesioner_id',
        'pertanyaan_id',
        'siswa_id',
        'jawaban',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Relationship: JawabanKuesioner belongs to Kuesioner
     */
    public function kuesioner(): BelongsTo
    {
        return $this->belongsTo(Kuesioner::class, 'kuesioner_id');
    }

    /**
     * Relationship: JawabanKuesioner belongs to PertanyaanKuesioner
     */
    public function pertanyaan(): BelongsTo
    {
        return $this->belongsTo(PertanyaanKuesioner::class, 'pertanyaan_id');
    }

    /**
     * Relationship: JawabanKuesioner belongs to User (siswa)
     */
    public function siswa(): BelongsTo
    {
        return $this->belongsTo(User::class, 'siswa_id');
    }
}
