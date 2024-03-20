<?php

namespace App\Livewire;

use App\Events\UserClicked;
use App\Events\UserConnected;
use Livewire\Attributes\On;
use Livewire\Component;

class HomeComponent extends Component
{
    public string $username;

    public array $actions = [];

    public array $events = [];

    public function mount()
    {
        $this->username = bin2hex(random_bytes(5));
        UserConnected::dispatch($this->username);
    }

    public function buttonClick()
    {
        UserClicked::dispatch($this->username);
        $this->actions[] = 'click';
    }

    public function render()
    {
        return view('livewire.home');
    }

    #[On('echo:everyone,.user.connected')]
    public function userConnectedEvent($event)
    {
        $this->events[] = $event['username'].' connected.';
    }

    #[On('echo:everyone,.user.clicked')]
    public function userClickedEvent($event)
    {
        $this->events[] = $event['username'].' clicked.';
    }
}
