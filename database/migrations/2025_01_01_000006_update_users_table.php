<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Drop kolom yang tidak digunakan
            if (Schema::hasColumn('users', 'name')) {
                $table->dropColumn('name');
            }
            
            if (Schema::hasColumn('users', 'role')) {
                $table->dropColumn('role');
            }
            
            // Tambahkan kolom jika belum ada
            if (!Schema::hasColumn('users', 'nis_nip')) {
                $table->string('nis_nip', 20)->unique()->after('id');
            }
            
            if (!Schema::hasColumn('users', 'nama')) {
                $table->string('nama', 100)->after('nis_nip');
            }
            
            if (!Schema::hasColumn('users', 'peran')) {
                $table->enum('peran', ['admin', 'guru_bk', 'siswa'])->after('password');
            }
            
            if (!Schema::hasColumn('users', 'status')) {
                $table->enum('status', ['aktif', 'non-aktif'])->default('aktif')->after('peran');
            }
            
            if (!Schema::hasColumn('users', 'jenis_kelamin')) {
                $table->enum('jenis_kelamin', ['laki-laki', 'perempuan'])->nullable()->after('status');
            }
            
            if (!Schema::hasColumn('users', 'alamat')) {
                $table->text('alamat')->nullable()->after('jenis_kelamin');
            }
            
            if (!Schema::hasColumn('users', 'no_telepon')) {
                $table->string('no_telepon', 15)->nullable()->after('alamat');
            }
            
            if (!Schema::hasColumn('users', 'kelas_id')) {
                $table->foreignId('kelas_id')->nullable()->after('no_telepon')
                      ->constrained('kelas')->onDelete('set null');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Drop foreign key dulu
            if (Schema::hasColumn('users', 'kelas_id')) {
                $table->dropForeign(['kelas_id']);
            }
            
            // Drop kolom yang ditambahkan
            $table->dropColumn([
                'nis_nip',
                'nama',
                'peran',
                'status',
                'jenis_kelamin',
                'alamat',
                'no_telepon',
                'kelas_id'
            ]);
            
            // Restore kolom yang di-drop
            $table->string('name')->after('id');
            $table->enum('role', ['admin', 'guru_bk', 'siswa'])->default('siswa')->after('password');
        });
    }
};
