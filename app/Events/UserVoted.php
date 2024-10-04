<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class UserVoted implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(
        private string $username,
        private string $color,
        private int $buttonId,
        private int $newCount
    ) {}

    public function broadcastOn(): array
    {
        return [new Channel('everyone')];
    }

    public function broadcastAs(): string
    {
        return 'user.voted';
    }

    public function broadcastWith(): array
    {
        return [
            'username' => $this->username,
            'color' => $this->color,
            'buttonId' => $this->buttonId,
            'newCount' => $this->newCount,
        ];
    }
}
