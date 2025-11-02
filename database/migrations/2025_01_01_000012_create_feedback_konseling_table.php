<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('feedback_konseling', function (Blueprint $table) {
            $table->id();
            $table->foreignId('konseling_id')->constrained('konseling')->onDelete('cascade');
            $table->tinyInteger('rating')->unsigned()->nullable();
            $table->text('komentar')->nullable();
            $table->timestamps();
        });

        // Add check constraint for rating between 1-5 using raw SQL
        DB::statement('ALTER TABLE feedback_konseling ADD CONSTRAINT chk_rating CHECK (rating >= 1 AND rating <= 5)');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Drop constraint first before dropping table
        DB::statement('ALTER TABLE feedback_konseling DROP CONSTRAINT IF EXISTS chk_rating');
        Schema::dropIfExists('feedback_konseling');
    }
};
