<?php

namespace App\Livewire;

use App\Events\UserConnected;
use Livewire\Attributes\On;
use Livewire\Component;

class HomeComponent extends Component
{
    public array $logs = ['Logs'];

    public function mount()
    {
        UserConnected::dispatch('User Connected');
    }

    #[On('echo:everyone,UserConnected')]
    public function userConnectedEvent()
    {
        $this->logs[] = 'User Connected Event';
    }

    public function render()
    {
        return view('livewire.home');
    }
}
