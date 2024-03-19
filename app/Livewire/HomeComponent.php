<?php

namespace App\Livewire;

use App\Events\UserClicked;
use App\Events\UserConnected;
use Livewire\Attributes\On;
use Livewire\Component;

class HomeComponent extends Component
{
    public array $actions = [];

    public array $events = [];

    public function mount()
    {
        UserConnected::dispatch();
    }

    public function buttonClick()
    {
        UserClicked::dispatch();
        $this->actions[] = 'click';
    }

    public function render()
    {
        return view('livewire.home');
    }

    #[On('echo:everyone,.user.connected')]
    public function userConnectedEvent()
    {
        $this->events[] = 'UserConnected';
    }

    #[On('echo:everyone,.user.clicked')]
    public function userClickedEvent()
    {
        $this->events[] = 'UserClicked';
    }
}
