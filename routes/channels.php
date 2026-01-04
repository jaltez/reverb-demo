<?php

use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('App.Models.User.{id}', fn ($user, $id): bool => (int) $user->id === (int) $id);

Broadcast::channel('canvas.presence', fn (): array => [
    'username' => request()->cookie('canvas_username') ?? 'Guest',
    'color' => request()->cookie('canvas_color') ?? '#888888',
]);
