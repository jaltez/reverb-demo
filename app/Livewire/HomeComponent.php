<?php

namespace App\Livewire;

use App\Events\UserClicked;
use App\Events\UserConnected;
use Livewire\Attributes\On;
use Livewire\Component;

class HomeComponent extends Component
{
    public string $username = '';

    public string $color = '';

    public array $events = [];

    public function mount()
    {
        $this->username = bin2hex(random_bytes(5));
        $this->color = '#'.dechex(rand(0x000000, 0xFFFFFF));
        UserConnected::dispatch($this->username, $this->color);
    }

    public function userClick($x, $y)
    {
        $this->dispatch('renderClick', [
            'username' => $this->username,
            'color' => $this->color,
            'x' => $x,
            'y' => $y,
        ]);
        UserClicked::dispatch($this->username, $this->color, $x, $y);
    }

    public function render()
    {
        return view('livewire.home');
    }

    #[On('echo:everyone,.user.connected')]
    public function userConnectedEvent($event)
    {
        $this->events[] = 'Connected: '.json_encode($event);
    }

    #[On('echo:everyone,.user.clicked')]
    public function userClickedEvent($event)
    {
        $this->events[] = 'Click: '.json_encode($event);
        $this->dispatch('renderClick', $event);
    }
}
