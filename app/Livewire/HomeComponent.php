<?php

namespace App\Livewire;

use App\Events\UserConnected;
use App\Events\UserVoted;
use App\Jobs\SaveUserClick;
use App\Models\VoteOption;
use Livewire\Attributes\On;
use Livewire\Component;

class HomeComponent extends Component
{
    public string $username = '';

    public string $color = '';

    public array $events = [];

    public $buttons;

    public $maxCount;

    public function mount()
    {
        $this->username = bin2hex(random_bytes(5));
        $this->color = '#'.dechex(rand(0x000000, 0xFFFFFF));
        $this->buttons = VoteOption::all();
        $this->maxCount = $this->buttons->max('count');
        UserConnected::dispatch($this->username, $this->color);
    }

    public function incrementCount($buttonId)
    {
        UserVoted::dispatch($this->username, $this->color, $buttonId);
        SaveUserClick::dispatch($buttonId);
    }

    /* public function updatedCount()
    {
        // Perform any additional tasks here
        // For example, you might want to update a message to all users indicating who clicked last
        $this->emit('statusMessage', "{$this->username} clicked a button!");

        // Or you might want to perform some calculations based on the new counts
        // For example, checking if a certain threshold has been reached
        if (max($this->clickCounts) >= 10) {
            // Perform an action when one of the buttons has been clicked 10 times
            $this->emit('thresholdReached', 'A button has been clicked 10 times!');
        }
    } */

    public function render()
    {
        return view('livewire.home');
    }

    #[On('echo:everyone,.user.connected')]
    public function userConnectedEvent($event)
    {
        $this->events[] = 'Connected: '.json_encode($event);
    }

    #[On('echo:everyone,.user.voted')]
    public function userClickedEvent($event)
    {
        $this->events[] = 'Vote: '.json_encode($event);
        $this->dispatch('userVoted', $event);
    }
}
