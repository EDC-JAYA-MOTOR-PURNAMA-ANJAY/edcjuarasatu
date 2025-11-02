<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Kelas extends Model
{
    protected $table = 'kelas';

    protected $fillable = [
        'nama_kelas',
        'jurusan_id',
        'tahun_ajaran_id',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Relationship: Kelas belongs to Jurusan
     */
    public function jurusan(): BelongsTo
    {
        return $this->belongsTo(Jurusan::class, 'jurusan_id');
    }

    /**
     * Relationship: Kelas belongs to TahunAjaran
     */
    public function tahunAjaran(): BelongsTo
    {
        return $this->belongsTo(TahunAjaran::class, 'tahun_ajaran_id');
    }

    /**
     * Relationship: Kelas has many Users (siswa)
     */
    public function siswa(): HasMany
    {
        return $this->hasMany(User::class, 'kelas_id')->where('peran', 'siswa');
    }

    /**
     * Relationship: Kelas has many Users
     */
    public function users(): HasMany
    {
        return $this->hasMany(User::class, 'kelas_id');
    }
}
