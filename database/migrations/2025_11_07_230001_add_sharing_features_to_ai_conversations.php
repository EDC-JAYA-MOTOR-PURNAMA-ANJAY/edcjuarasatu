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
        Schema::table('ai_conversations', function (Blueprint $table) {
            // Add messages column first if not exists
            if (!Schema::hasColumn('ai_conversations', 'messages')) {
                $table->json('messages')->nullable()->after('is_crisis');
            }
            
            // Sharing features
            $table->boolean('is_shared_with_guru_bk')->default(false)->after('is_crisis');
            $table->timestamp('shared_at')->nullable()->after('is_shared_with_guru_bk');
            $table->text('sharing_note')->nullable()->after('shared_at');
            
            // Alert system
            $table->boolean('has_sensitive_content')->default(false)->after('sharing_note');
            $table->json('detected_keywords')->nullable()->after('has_sensitive_content');
            $table->enum('alert_level', ['none', 'low', 'medium', 'high', 'critical'])->default('none')->after('detected_keywords');
            $table->timestamp('alert_sent_at')->nullable()->after('alert_level');
            
            // Guru BK review
            $table->text('guru_bk_notes')->nullable()->after('alert_sent_at');
            $table->foreignId('reviewed_by')->nullable()->after('guru_bk_notes')->constrained('users')->onDelete('set null');
            $table->timestamp('reviewed_at')->nullable()->after('reviewed_by');
            $table->enum('status', ['active', 'shared', 'reviewed', 'archived'])->default('active')->after('reviewed_at');
            
            // Analytics (sentiment already exists, skip it!)
            $table->json('topics')->nullable()->after('status'); // ['akademik', 'keluarga', etc]
            $table->integer('message_count')->default(0)->after('topics');
            
            // Indexes
            $table->index('is_shared_with_guru_bk');
            $table->index('has_sensitive_content');
            $table->index('alert_level');
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ai_conversations', function (Blueprint $table) {
            $table->dropForeign(['reviewed_by']);
            
            $table->dropColumn([
                'is_shared_with_guru_bk',
                'shared_at',
                'sharing_note',
                'has_sensitive_content',
                'detected_keywords',
                'alert_level',
                'alert_sent_at',
                'guru_bk_notes',
                'reviewed_by',
                'reviewed_at',
                'status',
                // 'sentiment', // Don't drop - exists in original migration
                'topics',
                'message_count',
                'messages'
            ]);
        });
    }
};
