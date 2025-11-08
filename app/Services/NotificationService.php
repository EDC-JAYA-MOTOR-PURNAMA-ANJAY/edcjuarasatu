<?php

namespace App\Services;

use App\Models\Notification;
use App\Models\User;
use Illuminate\Support\Collection;

class NotificationService
{
    /**
     * Create notification for all students about new materi
     */
    public function notifyStudentsAboutNewMateri($materi): void
    {
        // Get all students (siswa)
        $students = User::where('role', 'siswa')->get();

        foreach ($students as $student) {
            // Build message based on jenis
            $message = "Guru BK telah menambahkan materi baru: \"{$materi->judul}\" - Kategori: {$materi->kategori}";
            if ($materi->file_path) {
                $message .= " ({$materi->file_extension} - {$materi->file_size})";
            }
            
            Notification::create([
                'type' => 'materi',
                'title' => 'Materi Baru Tersedia!',
                'message' => $message,
                'user_id' => $student->id,
                'related_id' => $materi->id,
                'related_type' => 'Materi',
                'data' => [
                    'materi_id' => $materi->id,
                    'materi_judul' => $materi->judul,
                    'materi_kategori' => $materi->kategori,
                    'materi_jenis' => $materi->jenis,
                    'guru_bk_name' => $materi->guruBK->name ?? 'Guru BK',
                    'thumbnail_url' => $materi->thumbnail_url,
                    'has_file' => !empty($materi->file_path),
                    'file_extension' => $materi->file_extension,
                    'file_size' => $materi->file_size,
                    'file_url' => $materi->file_url,
                ],
            ]);
        }
    }

    /**
     * Get unread notifications for user
     */
    public function getUnreadNotifications(int $userId): Collection
    {
        return Notification::forUser($userId)
            ->unread()
            ->latest()
            ->get();
    }

    /**
     * Get unread count for user
     */
    public function getUnreadCount(int $userId): int
    {
        return Notification::forUser($userId)
            ->unread()
            ->count();
    }

    /**
     * Mark notification as read
     */
    public function markAsRead(int $notificationId): bool
    {
        $notification = Notification::find($notificationId);
        if ($notification) {
            $notification->markAsRead();
            return true;
        }
        return false;
    }

    /**
     * Mark all notifications as read for user
     */
    public function markAllAsRead(int $userId): void
    {
        Notification::forUser($userId)
            ->unread()
            ->update([
                'is_read' => true,
                'read_at' => now(),
            ]);
    }

    /**
     * Delete old read notifications (cleanup)
     */
    public function deleteOldNotifications(int $daysOld = 30): int
    {
        return Notification::where('is_read', true)
            ->where('read_at', '<', now()->subDays($daysOld))
            ->delete();
    }

    /**
     * Notify student about appointment status change
     */
    public function notifyStudentAboutAppointment($appointment, string $action, ?string $reason = null): void
    {
        $messages = [
            'approved' => "Appointment Anda pada {$appointment->appointment_date} pukul {$appointment->appointment_time} telah disetujui oleh Guru BK.",
            'rejected' => "Appointment Anda pada {$appointment->appointment_date} telah ditolak." . ($reason ? " Alasan: {$reason}" : ""),
            'completed' => "Appointment Anda telah selesai. Terima kasih atas partisipasinya!",
            'cancelled' => "Appointment Anda pada {$appointment->appointment_date} telah dibatalkan.",
        ];

        $titles = [
            'approved' => '✅ Appointment Disetujui',
            'rejected' => '❌ Appointment Ditolak',
            'completed' => '🎉 Appointment Selesai',
            'cancelled' => '⚠️ Appointment Dibatalkan',
        ];

        $types = [
            'approved' => 'appointment_approved',
            'rejected' => 'appointment_rejected',
            'completed' => 'appointment_completed',
            'cancelled' => 'appointment_cancelled',
        ];

        Notification::create([
            'user_id' => $appointment->student_id,
            'type' => $types[$action] ?? 'appointment',
            'title' => $titles[$action] ?? 'Update Appointment',
            'message' => $messages[$action] ?? 'Status appointment Anda telah diupdate.',
            'data' => json_encode([
                'appointment_id' => $appointment->id,
                'appointment_date' => $appointment->appointment_date,
                'appointment_time' => $appointment->appointment_time,
                'status' => $appointment->status,
                'action' => $action,
                'guru_bk_name' => $appointment->guruBK->nama ?? 'Guru BK',
                'rejection_reason' => $reason,
                'guru_bk_notes' => $appointment->guru_bk_notes,
            ]),
            'is_read' => false,
        ]);
    }

    /**
     * Notify student about new konseling session
     */
    public function notifyStudentAboutKonseling($konseling): void
    {
        Notification::create([
            'user_id' => $konseling->siswa_id,
            'type' => 'konseling',
            'title' => '📅 Jadwal Konseling Baru',
            'message' => "Guru BK telah menjadwalkan sesi konseling untuk Anda pada {$konseling->tanggal}. Topik: {$konseling->topik}",
            'data' => json_encode([
                'konseling_id' => $konseling->id,
                'tanggal' => $konseling->tanggal,
                'topik' => $konseling->topik,
                'guru_bk_name' => $konseling->guruBK->nama ?? 'Guru BK',
            ]),
            'is_read' => false,
        ]);
    }

    /**
     * Notify student about konseling result/notes
     */
    public function notifyStudentAboutKonselingResult($hasilKonseling): void
    {
        Notification::create([
            'user_id' => $hasilKonseling->konseling->siswa_id,
            'type' => 'konseling_result',
            'title' => '📝 Catatan Konseling Tersedia',
            'message' => "Guru BK telah menambahkan catatan hasil konseling Anda. Silakan cek untuk detail lebih lanjut.",
            'data' => json_encode([
                'hasil_konseling_id' => $hasilKonseling->id,
                'konseling_id' => $hasilKonseling->konseling_id,
                'tanggal' => $hasilKonseling->konseling->tanggal ?? now()->format('Y-m-d'),
                'guru_bk_name' => $hasilKonseling->konseling->guruBK->nama ?? 'Guru BK',
            ]),
            'is_read' => false,
        ]);
    }

    /**
     * Notify student about pelanggaran record
     */
    public function notifyStudentAboutPelanggaran($pelanggaran): void
    {
        Notification::create([
            'user_id' => $pelanggaran->siswa_id,
            'type' => 'pelanggaran',
            'title' => '⚠️ Catatan Pelanggaran',
            'message' => "Terdapat catatan pelanggaran atas nama Anda: {$pelanggaran->jenis_pelanggaran}. Segera hubungi Guru BK untuk klarifikasi.",
            'data' => json_encode([
                'pelanggaran_id' => $pelanggaran->id,
                'jenis_pelanggaran' => $pelanggaran->jenis_pelanggaran,
                'tanggal_kejadian' => $pelanggaran->tanggal_kejadian,
                'sanksi' => $pelanggaran->sanksi,
                'pelapor_name' => $pelanggaran->pelapor->nama ?? 'Guru BK',
            ]),
            'is_read' => false,
        ]);
    }

    /**
     * Notify student about panggilan orang tua
     */
    public function notifyStudentAboutPanggilanOrangTua($panggilan): void
    {
        Notification::create([
            'user_id' => $panggilan->siswa_id,
            'type' => 'panggilan_ortu',
            'title' => '👨‍👩‍👦 Panggilan Orang Tua',
            'message' => "Orang tua/wali Anda akan dipanggil ke sekolah pada {$panggilan->tanggal_panggilan}. Keperluan: {$panggilan->keperluan}",
            'data' => json_encode([
                'panggilan_id' => $panggilan->id,
                'tanggal_panggilan' => $panggilan->tanggal_panggilan,
                'keperluan' => $panggilan->keperluan,
                'status' => $panggilan->status,
                'guru_bk_name' => $panggilan->guruBK->nama ?? 'Guru BK',
            ]),
            'is_read' => false,
        ]);
    }

    /**
     * Notify student about absensi record
     */
    public function notifyStudentAboutAbsensi($absensi): void
    {
        $statusMessages = [
            'hadir' => '✅ Kehadiran Anda telah dicatat',
            'sakit' => '🤒 Status sakit Anda telah dicatat',
            'izin' => '📝 Izin Anda telah dicatat',
            'alpha' => '❌ Ketidakhadiran tanpa keterangan telah dicatat',
        ];

        Notification::create([
            'user_id' => $absensi->siswa_id,
            'type' => 'absensi',
            'title' => '📊 Update Absensi',
            'message' => $statusMessages[$absensi->status] ?? "Status kehadiran Anda: {$absensi->status}",
            'data' => json_encode([
                'absensi_id' => $absensi->id,
                'tanggal' => $absensi->tanggal,
                'status' => $absensi->status,
                'keterangan' => $absensi->keterangan,
            ]),
            'is_read' => false,
        ]);
    }

    /**
     * Notify all students in a class
     */
    public function notifyClassStudents(int $kelasId, string $title, string $message, array $data = []): void
    {
        $students = User::where('peran', 'siswa')
            ->where('kelas_id', $kelasId)
            ->get();

        foreach ($students as $student) {
            Notification::create([
                'user_id' => $student->id,
                'type' => 'pengumuman_kelas',
                'title' => $title,
                'message' => $message,
                'data' => json_encode($data),
                'is_read' => false,
            ]);
        }
    }

    /**
     * Notify all students (broadcast)
     */
    public function notifyAllStudents(string $title, string $message, array $data = []): void
    {
        $students = User::where('peran', 'siswa')->get();

        foreach ($students as $student) {
            Notification::create([
                'user_id' => $student->id,
                'type' => 'pengumuman',
                'title' => $title,
                'message' => $message,
                'data' => json_encode($data),
                'is_read' => false,
            ]);
        }
    }
}
