<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Storage;

class Materi extends Model
{
    use HasFactory;

    protected $table = 'materi';

    protected $fillable = [
        'jenis',
        'judul',
        'konten',
        'file_path',
        'thumbnail',
        'kategori',
        'target_kelas',
        'dibuat_oleh',
        'status',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Relationship: Materi belongs to User (Guru BK)
     */
    public function guruBK(): BelongsTo
    {
        return $this->belongsTo(User::class, 'dibuat_oleh');
    }

    /**
     * Relationship: Materi has many Notifications
     */
    public function notifications()
    {
        return $this->hasMany(Notification::class, 'related_id')->where('related_type', 'Materi');
    }

    /**
     * Accessor: Get full thumbnail URL
     */
    public function getThumbnailUrlAttribute(): ?string
    {
        if ($this->thumbnail) {
            return Storage::url($this->thumbnail);
        }
        return asset('images/default-thumbnail.png');
    }

    /**
     * Accessor: Get full file URL for download
     */
    public function getFileUrlAttribute(): ?string
    {
        if ($this->file_path) {
            return Storage::url($this->file_path);
        }
        return null;
    }

    /**
     * Accessor: Get file extension
     */
    public function getFileExtensionAttribute(): ?string
    {
        if ($this->file_path) {
            return strtoupper(pathinfo($this->file_path, PATHINFO_EXTENSION));
        }
        return null;
    }

    /**
     * Accessor: Get file size in human readable format
     */
    public function getFileSizeAttribute(): ?string
    {
        if ($this->file_path && Storage::exists($this->file_path)) {
            $bytes = Storage::size($this->file_path);
            $units = ['B', 'KB', 'MB', 'GB'];
            $i = 0;
            while ($bytes >= 1024 && $i < count($units) - 1) {
                $bytes /= 1024;
                $i++;
            }
            return round($bytes, 2) . ' ' . $units[$i];
        }
        return null;
    }

    /**
     * Scope: Filter only active materials
     */
    public function scopeAktif($query)
    {
        return $query->where('status', 'Aktif');
    }

    /**
     * Scope: Filter by category
     */
    public function scopeKategori($query, $kategori)
    {
        return $query->where('kategori', $kategori);
    }

    /**
     * Scope: Filter by target class
     */
    public function scopeTargetKelas($query, $kelas)
    {
        return $query->where('target_kelas', $kelas);
    }

    /**
     * Scope: Filter by Guru BK
     */
    public function scopeByGuruBK($query, $guruBKId)
    {
        return $query->where('dibuat_oleh', $guruBKId);
    }

    /**
     * Scope: Search by title or content
     */
    public function scopeSearch($query, $keyword)
    {
        return $query->where(function ($q) use ($keyword) {
            $q->where('judul', 'like', "%{$keyword}%")
              ->orWhere('konten', 'like', "%{$keyword}%");
        });
    }
}
