<?php

namespace App\Livewire;

use App\Events\UserConnected;
use App\Events\UserVoted;
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

    public int $maxCount = 0;

    public function mount(): void
    {
        $this->username = $this->generateUsername();
        $this->color = $this->generateColor();
        $this->refreshVotes();
        $this->dispatchUserConnectedEvent();
    }

    public function incrementCount(VoteOption $button): void
    {
        $button->increment('count');
        $this->refreshVotes();
        $this->dispatchUserVotedEvent($button);
    }

    public function refreshVotes(): void
    {
        $this->buttons = VoteOption::all();
        $this->maxCount = $this->buttons->max('count') ?? 0;
    }

    public function render()
    {
        return view('livewire.home');
    }

    #[On('echo:everyone,.user.connected')]
    public function userConnectedEvent(array $event): void
    {
        $this->addEvent('Connected', $event);
    }

    #[On('echo:everyone,.user.voted')]
    public function userVotedEvent(array $event): void
    {
        $this->addEvent('Vote', $event);
    }

    private function generateUsername(): string
    {
        return bin2hex(random_bytes(5));
    }

    private function generateColor(): string
    {
        return '#'.str_pad(dechex(mt_rand(0, 0xFFFFFF)), 6, '0', STR_PAD_LEFT);
    }

    private function dispatchUserConnectedEvent(): void
    {
        UserConnected::dispatch($this->username, $this->color);
    }

    private function dispatchUserVotedEvent(VoteOption $button): void
    {
        UserVoted::dispatch($this->username, $this->color, $button->id, $button->count);
    }

    private function addEvent(string $type, array $data): void
    {
        $this->events[] = $type.': '.json_encode($data);
    }
}
