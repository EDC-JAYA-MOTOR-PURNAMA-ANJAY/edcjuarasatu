<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HasilKonseling extends Model
{
    protected $table = 'hasil_konseling';

    protected $fillable = [
        'konseling_id',
        'catatan',
        'tindak_lanjut',
        'tanggal_selesai',
    ];

    protected $casts = [
        'tanggal_selesai' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Relationship: HasilKonseling belongs to Konseling
     */
    public function konseling(): BelongsTo
    {
        return $this->belongsTo(Konseling::class, 'konseling_id');
    }
}
