<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Konseling extends Model
{
    protected $table = 'konseling';

    protected $fillable = [
        'siswa_id',
        'nama_siswa',
        'kelas',
        'jurusan_id',
        'guru_bk_id',
        'metode_konseling',
        'jenis_konseling',
        'kategori_masalah_id',
        'judul',
        'deskripsi',
        'tanggal_pengajuan',
        'waktu_pengajuan',
        'tanggal_konseling',
        'waktu_konseling',
        'status',
        'alasan_penolakan',
    ];

    protected $casts = [
        'tanggal_pengajuan' => 'date',
        'tanggal_konseling' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Relationship: Konseling belongs to User (siswa)
     */
    public function siswa(): BelongsTo
    {
        return $this->belongsTo(User::class, 'siswa_id');
    }

    /**
     * Relationship: Konseling belongs to User (guru_bk)
     */
    public function guruBK(): BelongsTo
    {
        return $this->belongsTo(User::class, 'guru_bk_id');
    }

    /**
     * Relationship: Konseling belongs to Jurusan
     */
    public function jurusan(): BelongsTo
    {
        return $this->belongsTo(Jurusan::class, 'jurusan_id');
    }

    /**
     * Relationship: Konseling belongs to KategoriMasalah
     */
    public function kategoriMasalah(): BelongsTo
    {
        return $this->belongsTo(KategoriMasalah::class, 'kategori_masalah_id');
    }

    /**
     * Relationship: Konseling has one HasilKonseling
     */
    public function hasilKonseling(): HasOne
    {
        return $this->hasOne(HasilKonseling::class, 'konseling_id');
    }

    /**
     * Relationship: Konseling has many FeedbackKonseling
     */
    public function feedback(): HasMany
    {
        return $this->hasMany(FeedbackKonseling::class, 'konseling_id');
    }
}
