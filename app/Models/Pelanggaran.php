<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pelanggaran extends Model
{
    protected $table = 'pelanggaran';

    protected $fillable = [
        'siswa_id',
        'guru_bk_id',
        'jenis_pelanggaran',
        'kategori',
        'deskripsi',
        'tanggal_pelanggaran',
        'status',
        'sanksi',
        'tindak_lanjut',
    ];

    protected $casts = [
        'tanggal_pelanggaran' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Relationship: Pelanggaran belongs to User (siswa)
     */
    public function siswa(): BelongsTo
    {
        return $this->belongsTo(User::class, 'siswa_id');
    }

    /**
     * Relationship: Pelanggaran belongs to User (guru_bk)
     */
    public function guruBK(): BelongsTo
    {
        return $this->belongsTo(User::class, 'guru_bk_id');
    }

    /**
     * Relationship: Pelanggaran belongs to User (pelapor) - alias for guruBK
     */
    public function pelapor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'guru_bk_id');
    }

    /**
     * Accessor: Get tingkat based on jenis_pelanggaran
     */
    public function getTingkatAttribute()
    {
        return strtolower($this->jenis_pelanggaran);
    }
}
