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
        Schema::create('pelanggaran', function (Blueprint $table) {
            $table->id();
            $table->foreignId('siswa_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('guru_bk_id')->nullable()->constrained('users')->onDelete('set null');
            $table->string('jenis_pelanggaran'); // Ringan, Sedang, Berat
            $table->string('kategori'); // Terlambat, Tidak Berseragam, Bolos, dll
            $table->text('deskripsi');
            $table->date('tanggal_pelanggaran');
            $table->enum('status', ['aktif', 'selesai'])->default('aktif');
            $table->text('sanksi')->nullable();
            $table->text('tindak_lanjut')->nullable();
            $table->timestamps();
            
            // Index untuk pencarian cepat
            $table->index(['siswa_id', 'tanggal_pelanggaran']);
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pelanggaran');
    }
};
