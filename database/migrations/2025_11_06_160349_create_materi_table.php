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
        Schema::create('materi', function (Blueprint $table) {
            $table->id();
            $table->string('jenis', 50); // Artikel, Video Link
            $table->string('judul', 255);
            $table->text('konten');
            $table->string('thumbnail', 255)->nullable(); // URL file thumbnail
            $table->string('kategori', 100); // Motivasi, Akademik, Kesehatan Mental, Karier
            $table->string('target_kelas', 50); // Semua Kelas, Kelas X, XI, XII
            $table->unsignedBigInteger('dibuat_oleh'); // ID Guru BK
            $table->enum('status', ['Aktif', 'Nonaktif'])->default('Aktif');
            $table->timestamps();
            
            // Foreign key
            $table->foreign('dibuat_oleh')->references('id')->on('users')->onDelete('cascade');
            
            // Indexes untuk performa
            $table->index('status');
            $table->index('kategori');
            $table->index('dibuat_oleh');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('materi');
    }
};
