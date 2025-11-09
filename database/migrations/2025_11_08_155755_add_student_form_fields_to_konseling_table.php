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
        Schema::table('konseling', function (Blueprint $table) {
            // Make kategori_masalah_id nullable (not all forms require it)
            $table->foreignId('kategori_masalah_id')->nullable()->change();
            
            // Add student form fields
            $table->string('nama_siswa', 100)->after('siswa_id')->nullable();
            $table->string('kelas', 20)->after('nama_siswa')->nullable();
            $table->foreignId('jurusan_id')->after('kelas')->nullable()->constrained('jurusan')->onDelete('set null');
            
            // Add metode and jenis konseling
            $table->enum('metode_konseling', ['offline', 'online'])->after('guru_bk_id')->default('offline');
            $table->string('jenis_konseling', 50)->after('metode_konseling')->nullable();
            
            // Make judul nullable untuk flexibility
            $table->string('judul', 100)->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('konseling', function (Blueprint $table) {
            // Drop added columns
            $table->dropForeign(['jurusan_id']);
            $table->dropColumn(['nama_siswa', 'kelas', 'jurusan_id', 'metode_konseling', 'jenis_konseling']);
        });
    }
};
