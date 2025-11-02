<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Kuesioner extends Model
{
    protected $table = 'kuesioner';

    protected $fillable = [
        'judul',
        'jenis_kuesioner_id',
        'deskripsi',
        'created_by',
        'expired_at',
    ];

    protected $casts = [
        'expired_at' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Relationship: Kuesioner belongs to JenisKuesioner
     */
    public function jenisKuesioner(): BelongsTo
    {
        return $this->belongsTo(JenisKuesioner::class, 'jenis_kuesioner_id');
    }

    /**
     * Relationship: Kuesioner belongs to User (creator)
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Relationship: Kuesioner has many PertanyaanKuesioner
     */
    public function pertanyaan(): HasMany
    {
        return $this->hasMany(PertanyaanKuesioner::class, 'kuesioner_id');
    }

    /**
     * Relationship: Kuesioner has many JawabanKuesioner
     */
    public function jawaban(): HasMany
    {
        return $this->hasMany(JawabanKuesioner::class, 'kuesioner_id');
    }

    /**
     * Relationship: Kuesioner has one HasilAnalisisKuesioner
     */
    public function hasilAnalisis(): HasOne
    {
        return $this->hasOne(HasilAnalisisKuesioner::class, 'kuesioner_id');
    }
}
