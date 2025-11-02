<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class KategoriMasalah extends Model
{
    protected $table = 'kategori_masalah';

    protected $fillable = [
        'nama_kategori',
        'deskripsi',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Relationship: KategoriMasalah has many Konseling
     */
    public function konseling(): HasMany
    {
        return $this->hasMany(Konseling::class, 'kategori_masalah_id');
    }
}
