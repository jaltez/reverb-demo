<?php

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class UserLeftCanvas implements ShouldBroadcast
{
    use Dispatchable;
    use InteractsWithSockets;
    use SerializesModels;

    public function __construct(
        public string $username
    ) {}

    public function broadcastOn(): PresenceChannel
    {
        return new PresenceChannel('canvas.presence');
    }

    public function broadcastAs(): string
    {
        return 'user.left';
    }
}
