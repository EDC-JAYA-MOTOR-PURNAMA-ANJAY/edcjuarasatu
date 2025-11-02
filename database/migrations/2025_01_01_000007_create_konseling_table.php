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
        Schema::create('konseling', function (Blueprint $table) {
            $table->id();
            $table->foreignId('siswa_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('guru_bk_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('kategori_masalah_id')->constrained('kategori_masalah')->onDelete('cascade');
            $table->string('judul', 100);
            $table->text('deskripsi')->nullable();
            $table->date('tanggal_pengajuan');
            $table->time('waktu_pengajuan');
            $table->date('tanggal_konseling')->nullable();
            $table->time('waktu_konseling')->nullable();
            $table->enum('status', [
                'menunggu_persetujuan',
                'diproses',
                'dikonfirmasi',
                'ditolak',
                'selesai'
            ])->default('menunggu_persetujuan');
            $table->text('alasan_penolakan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('konseling');
    }
};
