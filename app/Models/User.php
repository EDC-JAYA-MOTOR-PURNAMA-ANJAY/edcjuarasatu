<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * Atribut yang dapat diisi secara massal.
     *
     * @var list<string>
     */
    protected $fillable = [
        'nis_nip',
        'nama',
        'email',
        'password',
        'peran',
        'status',
        'jenis_kelamin',
        'alamat',
        'no_telepon',
        'kelas_id',
        'remember_token',
    ];

    /**
     * Atribut yang harus disembunyikan saat serialisasi.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Atribut yang perlu dikonversi tipe datanya.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Relationship: User belongs to Kelas (for siswa)
     */
    public function kelas(): BelongsTo
    {
        return $this->belongsTo(Kelas::class, 'kelas_id');
    }

    /**
     * Relationship: User (siswa) has many Konseling
     */
    public function konselingAsSiswa(): HasMany
    {
        return $this->hasMany(Konseling::class, 'siswa_id');
    }

    /**
     * Relationship: User (guru_bk) has many Konseling
     */
    public function konselingAsGuruBK(): HasMany
    {
        return $this->hasMany(Konseling::class, 'guru_bk_id');
    }

    /**
     * Relationship: User created many Kuesioner
     */
    public function kuesioner(): HasMany
    {
        return $this->hasMany(Kuesioner::class, 'created_by');
    }

    /**
     * Relationship: User (siswa) has many JawabanKuesioner
     */
    public function jawabanKuesioner(): HasMany
    {
        return $this->hasMany(JawabanKuesioner::class, 'siswa_id');
    }

    /**
     * Relationship: User created many Materi
     */
    public function materi(): HasMany
    {
        return $this->hasMany(Materi::class, 'created_by');
    }

    /**
     * Relationship: User created many Laporan
     */
    public function laporan(): HasMany
    {
        return $this->hasMany(Laporan::class, 'created_by');
    }

    /**
     * Relationship: User (siswa) has many Absensi
     */
    public function absensi(): HasMany
    {
        return $this->hasMany(Absensi::class, 'siswa_id');
    }

    /**
     * Relationship: User verified many Absensi
     */
    public function absensiVerified(): HasMany
    {
        return $this->hasMany(Absensi::class, 'verified_by');
    }

    /**
     * Accessor: Get 'role' attribute (alias for 'peran')
     * Untuk kompatibilitas dengan code yang menggunakan 'role'
     */
    public function getRoleAttribute()
    {
        return $this->peran;
    }

    /**
     * Mutator: Set 'role' attribute (will set 'peran')
     */
    public function setRoleAttribute($value)
    {
        $this->attributes['peran'] = $value;
    }

    /**
     * Check if user has specific role
     */
    public function hasRole(string $role): bool
    {
        // Support both 'siswa' and 'student'
        $roleMap = [
            'student' => 'siswa',
            'siswa' => 'siswa',
            'admin' => 'admin',
            'guru_bk' => 'guru_bk',
            'teacher' => 'guru_bk',
        ];

        $checkRole = $roleMap[$role] ?? $role;
        return $this->peran === $checkRole;
    }

    /**
     * Check if user is admin
     */
    public function isAdmin(): bool
    {
        return $this->peran === 'admin';
    }

    /**
     * Check if user is student/siswa
     */
    public function isStudent(): bool
    {
        return $this->peran === 'siswa';
    }

    /**
     * Check if user is guru BK
     */
    public function isGuruBK(): bool
    {
        return $this->peran === 'guru_bk';
    }
}
