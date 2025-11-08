<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AiConversation extends Model
{
    protected $fillable = [
        'user_id',
        'role',
        'message',
        'sentiment',
        'is_crisis',
        'messages',
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
        'topics',
        'message_count',
    ];

    protected $casts = [
        'is_crisis' => 'boolean',
        'is_shared_with_guru_bk' => 'boolean',
        'has_sensitive_content' => 'boolean',
        'detected_keywords' => 'array',
        'topics' => 'array',
        'messages' => 'array',
        'shared_at' => 'datetime',
        'alert_sent_at' => 'datetime',
        'reviewed_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the user that owns the conversation
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the guru BK who reviewed this conversation
     */
    public function reviewer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }

    /**
     * Scope: Only shared conversations
     */
    public function scopeShared($query)
    {
        return $query->where('is_shared_with_guru_bk', true);
    }

    /**
     * Scope: Has sensitive content
     */
    public function scopeSensitive($query)
    {
        return $query->where('has_sensitive_content', true);
    }

    /**
     * Scope: By alert level
     */
    public function scopeByAlertLevel($query, string $level)
    {
        return $query->where('alert_level', $level);
    }

    /**
     * Scope: Needs attention (high or critical)
     */
    public function scopeNeedsAttention($query)
    {
        return $query->whereIn('alert_level', ['high', 'critical']);
    }

    /**
     * Get alert level badge
     */
    public function getAlertBadgeAttribute(): string
    {
        $badges = [
            'critical' => '<span class="badge bg-danger">🚨 KRITIS</span>',
            'high' => '<span class="badge bg-warning">⚠️ TINGGI</span>',
            'medium' => '<span class="badge bg-info">📌 SEDANG</span>',
            'low' => '<span class="badge bg-secondary">ℹ️ RENDAH</span>',
            'none' => '<span class="badge bg-light text-dark">-</span>',
        ];

        return $badges[$this->alert_level] ?? $badges['none'];
    }

    /**
     * Get sentiment badge
     */
    public function getSentimentBadgeAttribute(): string
    {
        $badges = [
            'positive' => '<span class="badge bg-success">😊 Positif</span>',
            'neutral' => '<span class="badge bg-secondary">😐 Netral</span>',
            'negative' => '<span class="badge bg-danger">😢 Negatif</span>',
        ];

        return $badges[$this->sentiment] ?? $badges['neutral'];
    }

    /**
     * Get status badge
     */
    public function getStatusBadgeAttribute(): string
    {
        $badges = [
            'active' => '<span class="badge bg-primary">Aktif</span>',
            'shared' => '<span class="badge bg-info">Dibagikan</span>',
            'reviewed' => '<span class="badge bg-success">Ditinjau</span>',
            'archived' => '<span class="badge bg-secondary">Arsip</span>',
        ];

        return $badges[$this->status] ?? $badges['active'];
    }

    /**
     * Get topics as comma-separated string
     */
    public function getTopicsStringAttribute(): string
    {
        if (!$this->topics || count($this->topics) === 0) {
            return '-';
        }

        return implode(', ', array_map('ucfirst', $this->topics));
    }
}
