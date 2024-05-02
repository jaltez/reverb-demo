<?php

namespace App\Livewire;

use App\Events\UserConnected;
use App\Events\UserVoted;
use App\Jobs\SaveUserClick;
use App\Models\VoteOption;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Attributes\On;
use Livewire\Component;

class HomeComponent extends Component
{
    public string $username = '';

    public string $color = '';

    public array $events = [];

    public Collection $buttons;

    public int $maxCount;

    public function mount()
    {
        $this->username = bin2hex(random_bytes(5));
        $this->color = '#'.dechex(rand(0x000000, 0xFFFFFF));
        $this->refreshVotes();
        $this->updateMaxCount();
        UserConnected::dispatch($this->username, $this->color);
    }

    public function incrementCount(VoteOption $button)
    {
        $button->count++;
        UserVoted::dispatch($this->username, $this->color, $button->id);
        SaveUserClick::dispatch($button->id);
        $this->updateMaxCount();
    }

    public function refreshVotes()
    {
        $this->buttons = VoteOption::all();
    }

    private function updateMaxCount()
    {
        $this->maxCount = $this->buttons->max('count');
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

    #[On('echo:everyone,.user.voted')]
    public function userClickedEvent($event)
    {
        $this->updateMaxCount();
        $this->refreshVotes();
        $this->events[] = 'Vote: '.json_encode($event);
        $this->dispatch('userVoted', $event);
    }
}
