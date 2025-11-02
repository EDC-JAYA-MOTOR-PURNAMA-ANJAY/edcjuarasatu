<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class JenisKuesioner extends Model
{
    protected $table = 'jenis_kuesioner';

    protected $fillable = [
        'nama_kuesioner',
        'deskripsi',
        'tipe',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Relationship: JenisKuesioner has many Kuesioner
     */
    public function kuesioner(): HasMany
    {
        return $this->hasMany(Kuesioner::class, 'jenis_kuesioner_id');
    }
}
