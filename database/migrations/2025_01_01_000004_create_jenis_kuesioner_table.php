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
        Schema::create('jenis_kuesioner', function (Blueprint $table) {
            $table->id();
            $table->string('nama_kuesioner', 100);
            $table->text('deskripsi')->nullable();
            $table->enum('tipe', ['layanan_bk', 'akademik', 'lainnya']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jenis_kuesioner');
    }
};
