<?php

use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

Broadcast::channel('canvas.presence', function () {
    return [
        'username' => request()->cookie('canvas_username') ?? 'Guest',
        'color' => request()->cookie('canvas_color') ?? '#888888',
    ];
});
