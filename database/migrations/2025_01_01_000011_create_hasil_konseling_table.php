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
        Schema::create('hasil_konseling', function (Blueprint $table) {
            $table->id();
            $table->foreignId('konseling_id')->constrained('konseling')->onDelete('cascade');
            $table->text('catatan');
            $table->text('tindak_lanjut')->nullable();
            $table->date('tanggal_selesai')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hasil_konseling');
    }
};
