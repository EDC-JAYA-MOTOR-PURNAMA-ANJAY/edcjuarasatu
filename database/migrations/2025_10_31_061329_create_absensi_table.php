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
        Schema::create('absensi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('siswa_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('kelas_id')->nullable()->constrained('kelas')->onDelete('set null');
            $table->foreignId('tahun_ajaran_id')->nullable()->constrained('tahun_ajaran')->onDelete('set null');
            $table->date('tanggal');
            $table->time('waktu_masuk')->nullable();
            $table->time('waktu_keluar')->nullable();
            $table->enum('status', [
                'hadir',
                'izin',
                'sakit',
                'alpha'
            ])->default('hadir');
            $table->text('keterangan')->nullable();
            $table->string('bukti_file')->nullable(); // Untuk surat izin/sakit
            $table->foreignId('verified_by')->nullable()->constrained('users')->onDelete('set null'); // Guru yang verifikasi
            $table->timestamp('verified_at')->nullable();
            $table->timestamps();
            
            // Index untuk pencarian cepat
            $table->index(['siswa_id', 'tanggal']);
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('absensi');
    }
};
