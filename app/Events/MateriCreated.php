<?php

namespace App\Events;

use App\Models\Materi;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class MateriCreated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $materi;

    /**
     * Create a new event instance.
     */
    public function __construct(Materi $materi)
    {
        $this->materi = $materi;
    }

    /**
     * Get the channels the event should broadcast on.
     */
    public function broadcastOn(): Channel
    {
        return new Channel('materi-updates');
    }

    /**
     * The event's broadcast name.
     */
    public function broadcastAs(): string
    {
        return 'materi.created';
    }

    /**
     * Get the data to broadcast.
     */
    public function broadcastWith(): array
    {
        return [
            'id' => $this->materi->id,
            'judul' => $this->materi->judul,
            'kategori' => $this->materi->kategori,
            'jenis' => $this->materi->jenis,
            'guru_bk_name' => $this->materi->guruBK->name ?? 'Guru BK',
            'created_at' => $this->materi->created_at->format('Y-m-d H:i:s'),
            'thumbnail_url' => $this->materi->thumbnail_url,
            'has_file' => !empty($this->materi->file_path),
            'file_extension' => $this->materi->file_extension,
            'file_size' => $this->materi->file_size,
        ];
    }
}
