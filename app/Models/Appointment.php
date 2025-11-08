<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Appointment extends Model
{
    protected $fillable = [
        'student_id',
        'guru_bk_id',
        'appointment_date',
        'appointment_time',
        'duration',
        'status',
        'topic',
        'student_notes',
        'guru_bk_notes',
        'rejection_reason',
        'approved_at',
        'completed_at',
    ];

    protected $casts = [
        'appointment_date' => 'date',
        'appointment_time' => 'datetime:H:i',
        'approved_at' => 'datetime',
        'completed_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Relationship: Appointment belongs to Student (User)
     */
    public function student(): BelongsTo
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    /**
     * Relationship: Appointment belongs to Guru BK (User)
     */
    public function guruBK(): BelongsTo
    {
        return $this->belongsTo(User::class, 'guru_bk_id');
    }

    /**
     * Scope: Get pending appointments
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * Scope: Get approved appointments
     */
    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    /**
     * Scope: Get completed appointments
     */
    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    /**
     * Scope: Get upcoming appointments
     */
    public function scopeUpcoming($query)
    {
        return $query->where('appointment_date', '>=', now()->toDateString())
                     ->whereIn('status', ['pending', 'approved'])
                     ->orderBy('appointment_date')
                     ->orderBy('appointment_time');
    }

    /**
     * Scope: Get past appointments
     */
    public function scopePast($query)
    {
        return $query->where('appointment_date', '<', now()->toDateString())
                     ->orderBy('appointment_date', 'desc');
    }

    /**
     * Check if appointment is pending
     */
    public function isPending(): bool
    {
        return $this->status === 'pending';
    }

    /**
     * Check if appointment is approved
     */
    public function isApproved(): bool
    {
        return $this->status === 'approved';
    }

    /**
     * Check if appointment is completed
     */
    public function isCompleted(): bool
    {
        return $this->status === 'completed';
    }

    /**
     * Get status badge color
     */
    public function getStatusBadgeAttribute(): string
    {
        return match($this->status) {
            'pending' => 'warning',
            'approved' => 'success',
            'rejected' => 'danger',
            'completed' => 'info',
            'cancelled' => 'secondary',
            default => 'secondary',
        };
    }

    /**
     * Get formatted date time
     */
    public function getFormattedDateTimeAttribute(): string
    {
        return $this->appointment_date->format('d M Y') . ' at ' . $this->appointment_time->format('H:i');
    }
}
