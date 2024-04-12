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
        public string $username,
        public string $color,
        public int $buttonId
    ) {
    }

    public function broadcastOn(): array
    {
        return [new Channel('everyone')];
    }

    public function broadcastAs(): string
    {
        return 'user.voted';
    }
}
