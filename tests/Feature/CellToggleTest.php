<?php

namespace Tests\Feature;

use App\Events\CellToggled;
use App\Models\CanvasCell;
use Illuminate\Support\Facades\Event;
use Livewire\Livewire;
use Tests\TestCase;

class CellToggleTest extends TestCase
{
    public function test_toggling_cell_creates_new_record(): void
    {
        Livewire::test(\App\Livewire\CanvasComponent::class)
            ->call('toggleCell', 5, 10)
            ->assertSet('cells.5_10.isChecked', true);

        $this->assertDatabaseHas('canvas_cells', [
            'row' => 5,
            'column' => 10,
            'is_checked' => true,
            'click_count' => 1,
        ]);
    }

    public function test_toggling_cell_broadcasts_event(): void
    {
        Event::fake();

        Livewire::test(\App\Livewire\CanvasComponent::class)
            ->call('toggleCell', 3, 7);

        Event::assertDispatched(CellToggled::class, fn ($event): bool => $event->row === 3 && $event->column === 7);
    }

    public function test_multiple_toggles_increment_click_count(): void
    {
        Livewire::test(\App\Livewire\CanvasComponent::class)
            ->call('toggleCell', 2, 2)
            ->assertSet('cells.2_2.clickCount', 1)
            ->call('toggleCell', 2, 2)
            ->assertSet('cells.2_2.clickCount', 2)
            ->call('toggleCell', 2, 2)
            ->assertSet('cells.2_2.clickCount', 3);

        $cell = CanvasCell::where('row', 2)->where('column', 2)->first();
        $this->assertEquals(3, $cell->click_count);
    }

    public function test_listening_to_cell_toggled_event(): void
    {
        Livewire::test(\App\Livewire\CanvasComponent::class)
            ->call('onCellToggled', [
                'cellId' => 1,
                'row' => 10,
                'column' => 15,
                'isChecked' => true,
                'clickCount' => 1,
                'username' => 'TestUser',
                'color' => '#FF0000',
            ])
            ->assertSet('cells.10_15.isChecked', true)
            ->assertSet('cells.10_15.clickCount', 1);
    }

    public function test_listening_to_presence_here_event(): void
    {
        $users = [
            ['username' => 'SwiftArtist1a2b', 'color' => '#EF4444'],
            ['username' => 'CalmPainter3c4d', 'color' => '#3B82F6'],
        ];

        Livewire::test(\App\Livewire\CanvasComponent::class)
            ->call('onPresenceHere', $users)
            ->assertSet('onlineUsers', $users);
    }

    public function test_listening_to_presence_joining_event(): void
    {
        $newUser = ['username' => 'BoldCreator5e6f', 'color' => '#22C55E'];

        Livewire::test(\App\Livewire\CanvasComponent::class)
            ->set('onlineUsers', [['username' => 'ExistingUser', 'color' => '#888888']])
            ->call('onPresenceJoining', $newUser)
            ->assertSet('onlineUsers.1', $newUser);
    }

    public function test_listening_to_presence_leaving_event(): void
    {
        $leavingUser = ['username' => 'LeavingUser', 'color' => '#F43F5E'];

        Livewire::test(\App\Livewire\CanvasComponent::class)
            ->set('onlineUsers', [
                ['username' => 'StayingUser', 'color' => '#888888'],
                $leavingUser,
            ])
            ->call('onPresenceLeaving', $leavingUser)
            ->assertSet('onlineUsers', [['username' => 'StayingUser', 'color' => '#888888']]);
    }

    public function test_incremental_stats_update_on_toggle(): void
    {
        Livewire::test(\App\Livewire\CanvasComponent::class)
            ->call('toggleCell', 5, 5)
            ->assertSet('totalChecked', 1)
            ->assertSet('totalClicks', 1)
            ->call('toggleCell', 5, 5)
            ->assertSet('totalChecked', 0)
            ->assertSet('totalClicks', 2);
    }

    public function test_incremental_stats_update_on_remote_toggle(): void
    {
        Livewire::test(\App\Livewire\CanvasComponent::class)
            ->call('onCellToggled', [
                'cellId' => 1,
                'row' => 8,
                'column' => 8,
                'isChecked' => true,
                'clickCount' => 5,
                'color' => '#FF0000',
            ])
            ->assertSet('totalChecked', 1)
            ->assertSet('totalClicks', 5);
    }
}
