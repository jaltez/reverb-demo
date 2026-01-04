<?php

namespace App\Livewire;

use Livewire\Attributes\On;
use Livewire\Component;

class CanvasActivityFeed extends Component
{
    public array $activities = [];

    public int $maxActivities = 50;

    #[On('echo:canvas,.cell.toggled')]
    public function onCellToggled(array $event): void
    {
        $this->addActivity($event);
    }

    private function addActivity(array $data): void
    {
        $this->activities[] = [
            'data' => $data,
            'timestamp' => now()->format('H:i:s'),
        ];

        if (count($this->activities) > $this->maxActivities) {
            array_shift($this->activities);
        }
    }

    public function render()
    {
        return view('livewire.canvas-activity-feed');
    }
}
