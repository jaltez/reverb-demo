<?php

namespace App\Livewire;

use App\Events\CellToggled;
use App\Models\CanvasCell;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Livewire\Attributes\On;
use Livewire\Component;

class CanvasComponent extends Component
{
    public int $rows = 20;

    public int $columns = 20;

    public string $username = '';

    public string $color = '';

    public string $userId = '';

    public array $cells = [];

    public int $totalChecked = 0;

    public int $totalClicks = 0;

    public array $onlineUsers = [];

    public function mount(): void
    {
        $userId = Cookie::get('canvas_user_id');
        $username = Cookie::get('canvas_username');
        $color = Cookie::get('canvas_color');

        if (! $userId) {
            $this->userId = Str::uuid()->toString();
            $this->username = $this->generateUsername();
            $this->color = $this->generateColor();

            Cookie::queue('canvas_user_id', $this->userId, 60 * 24 * 30);
            Cookie::queue('canvas_username', $this->username, 60 * 24 * 30);
            Cookie::queue('canvas_color', $this->color, 60 * 24 * 30);
        } else {
            $this->userId = $userId;
            $this->username = $username ?? $this->generateUsername();
            $this->color = $color ?? $this->generateColor();
        }

        $this->loadCanvas();
    }

    public function loadCanvas(): void
    {
        $cells = CanvasCell::all()->keyBy(fn ($cell) => "{$cell->row}_{$cell->column}");

        $this->cells = [];

        $this->totalChecked = 0;
        $this->totalClicks = 0;

        for ($row = 0; $row < $this->rows; $row++) {
            for ($col = 0; $col < $this->columns; $col++) {
                $key = "{$row}_{$col}";
                if (isset($cells[$key])) {
                    $cell = $cells[$key];
                    $this->cells[$key] = [
                        'id' => $cell->id,
                        'row' => $cell->row,
                        'column' => $cell->column,
                        'isChecked' => $cell->is_checked,
                        'clickCount' => $cell->click_count,
                        'color' => $cell->color,
                    ];
                    if ($cell->is_checked) {
                        $this->totalChecked++;
                    }

                    $this->totalClicks += $cell->click_count;
                } else {
                    $this->cells[$key] = [
                        'id' => null,
                        'row' => $row,
                        'column' => $col,
                        'isChecked' => false,
                        'clickCount' => 0,
                        'color' => null,
                    ];
                }
            }
        }
    }

    public function toggleCell(int $row, int $column): void
    {
        $key = "{$row}_{$column}";

        // Rate limit: 60 toggles per minute per user
        $executed = RateLimiter::attempt(
            'canvas-toggle:'.$this->userId,
            60,
            function (): void {
                // Allow the action
            },
            60
        );

        if (! $executed) {
            $seconds = RateLimiter::availableIn('canvas-toggle:'.$this->userId);

            session()->flash('error', "Too many toggles! Please wait {$seconds} seconds.");

            return;
        }

        $cell = CanvasCell::firstOrCreate(
            ['row' => $row, 'column' => $column],
            ['is_checked' => false, 'click_count' => 0, 'color' => null]
        );

        $previousCheckedState = $cell->is_checked;
        $previousClickCount = $cell->click_count;

        $cell->toggle();
        $cell->color = $this->color;
        $cell->save();

        $this->cells[$key] = [
            'id' => $cell->id,
            'row' => $cell->row,
            'column' => $cell->column,
            'isChecked' => $cell->is_checked,
            'clickCount' => $cell->click_count,
            'color' => $cell->color,
        ];

        // Update stats incrementally
        $this->totalChecked += $cell->is_checked <=> $previousCheckedState;
        $this->totalClicks += $cell->click_count - $previousClickCount;

        CellToggled::dispatch(
            $cell->id,
            $cell->row,
            $cell->column,
            $cell->is_checked,
            $cell->click_count,
            $this->username,
            $this->color
        );
    }

    #[On('echo:canvas,.cell.toggled')]
    public function onCellToggled(array $event): void
    {
        $row = $event['row'];
        $column = $event['column'];
        $key = "{$row}_{$column}";

        $previousCheckedState = $this->cells[$key]['isChecked'] ?? false;
        $previousClickCount = $this->cells[$key]['clickCount'] ?? 0;

        $this->cells[$key] = [
            'id' => $event['cellId'],
            'row' => $row,
            'column' => $column,
            'isChecked' => $event['isChecked'],
            'clickCount' => $event['clickCount'],
            'color' => $event['color'],
        ];

        // Update stats incrementally
        $this->totalChecked += $event['isChecked'] <=> $previousCheckedState;
        $this->totalClicks += $event['clickCount'] - $previousClickCount;
    }

    #[On('echo-presence:canvas.presence,here')]
    public function onPresenceHere(array $users): void
    {
        $this->onlineUsers = $users;
    }

    #[On('echo-presence:canvas.presence,joining')]
    public function onPresenceJoining(array $user): void
    {
        $this->onlineUsers[] = $user;
    }

    #[On('echo-presence:canvas.presence,leaving')]
    public function onPresenceLeaving(array $user): void
    {
        $this->onlineUsers = collect($this->onlineUsers)
            ->reject(fn ($u) => $u['username'] === $user['username'])
            ->values()
            ->toArray();
    }

    private function generateUsername(): string
    {
        $adjectives = ['Swift', 'Calm', 'Bright', 'Bold', 'Gentle', 'Wild', 'Silent', 'Lucky'];
        $nouns = ['Artist', 'Painter', 'Creator', 'Designer', 'Drawer', 'Maker'];

        return $adjectives[array_rand($adjectives)].
               $nouns[array_rand($nouns)].
               bin2hex(random_bytes(2));
    }

    private function generateColor(): string
    {
        $colors = [
            '#EF4444', '#F97316', '#F59E0B', '#EAB308', '#84CC16',
            '#22C55E', '#10B981', '#14B8A6', '#06B6D4', '#0EA5E9',
            '#3B82F6', '#6366F1', '#8B5CF6', '#A855F7', '#D946EF',
            '#EC4899', '#F43F5E',
        ];

        return $colors[array_rand($colors)];
    }

    public function render()
    {
        return view('livewire.canvas')->layout('components.layouts.app', ['title' => 'Global Toggle Canvas']);
    }
}
