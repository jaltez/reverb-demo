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

    public array $actions = [];

    public array $events = [];

    public function mount()
    {
        $this->username = bin2hex(random_bytes(5));
        $this->color = '#'.substr(str_shuffle('ABCDEF0123456789'), 0, 6);
        UserConnected::dispatch($this->username, $this->color);
    }

    public function userClick($x, $y)
    {
        UserClicked::dispatch($this->username, $this->color, $x, $y);
        $this->actions[] = 'click';
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
