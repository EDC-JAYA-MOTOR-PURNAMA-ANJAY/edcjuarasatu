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
        Schema::table('materi', function (Blueprint $table) {
            $table->integer('durasi_menit')->nullable()->after('konten')->comment('Durasi untuk video dalam menit');
            $table->integer('total_halaman')->nullable()->after('durasi_menit')->comment('Total halaman untuk PDF');
            $table->text('deskripsi_singkat')->nullable()->after('total_halaman')->comment('Deskripsi singkat materi');
        });
        
        // Create progress tracking table
        Schema::create('materi_progress', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('materi_id')->constrained('materi')->onDelete('cascade');
            $table->integer('progress_percent')->default(0)->comment('Progress dalam persen 0-100');
            $table->integer('halaman_terakhir')->nullable()->comment('Halaman terakhir dibaca');
            $table->integer('menit_ditonton')->nullable()->comment('Menit video yang sudah ditonton');
            $table->boolean('is_completed')->default(false);
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();
            
            $table->unique(['user_id', 'materi_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('materi_progress');
        
        Schema::table('materi', function (Blueprint $table) {
            $table->dropColumn(['durasi_menit', 'total_halaman', 'deskripsi_singkat']);
        });
    }
};
