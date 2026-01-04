<?php

namespace Tests\Unit;

use App\Models\CanvasCell;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CanvasCellTest extends TestCase
{
    use RefreshDatabase;

    public function test_toggle_method_flips_is_checked(): void
    {
        $cell = CanvasCell::factory()->create([
            'is_checked' => false,
            'click_count' => 0,
        ]);

        $cell->toggle();

        $this->assertTrue($cell->is_checked);
        $this->assertEquals(1, $cell->click_count);
        $this->assertDatabaseHas('canvas_cells', [
            'id' => $cell->id,
            'is_checked' => true,
            'click_count' => 1,
        ]);

        $cell->toggle();

        $this->assertFalse($cell->is_checked);
        $this->assertEquals(2, $cell->click_count);
    }

    public function test_checked_scope_returns_only_checked_cells(): void
    {
        CanvasCell::factory()->create(['is_checked' => true]);
        CanvasCell::factory()->create(['is_checked' => false]);
        CanvasCell::factory()->create(['is_checked' => true]);

        $checkedCells = CanvasCell::checked()->get();

        $this->assertCount(2, $checkedCells);
        $checkedCells->each(function ($cell): void {
            $this->assertTrue($cell->is_checked);
        });
    }

    public function test_unchecked_scope_returns_only_unchecked_cells(): void
    {
        CanvasCell::factory()->create(['is_checked' => true]);
        CanvasCell::factory()->create(['is_checked' => false]);
        CanvasCell::factory()->create(['is_checked' => true]);

        $uncheckedCells = CanvasCell::unchecked()->get();

        $this->assertCount(1, $uncheckedCells);
        $uncheckedCells->each(function ($cell): void {
            $this->assertFalse($cell->is_checked);
        });
    }
}
