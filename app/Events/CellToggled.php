<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class CellToggled implements ShouldBroadcast
{
    use Dispatchable;
    use InteractsWithSockets;
    use SerializesModels;

    public function __construct(
        public int $cellId,
        public int $row,
        public int $column,
        public bool $isChecked,
        public int $clickCount,
        public string $username,
        public string $color
    ) {}

    public function broadcastOn(): array
    {
        return [
            new Channel('canvas'),
            new PresenceChannel('canvas.presence'),
        ];
    }

    public function broadcastAs(): string
    {
        return 'cell.toggled';
    }

    public function broadcastWith(): array
    {
        return [
            'cellId' => $this->cellId,
            'row' => $this->row,
            'column' => $this->column,
            'isChecked' => $this->isChecked,
            'clickCount' => $this->clickCount,
            'username' => $this->username,
            'color' => $this->color,
            'timestamp' => now()->toIso8601String(),
        ];
    }
}
