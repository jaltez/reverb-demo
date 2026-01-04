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

        Event::assertDispatched(CellToggled::class, function ($event) {
            return $event->row === 3 && $event->column === 7;
        });
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
}
