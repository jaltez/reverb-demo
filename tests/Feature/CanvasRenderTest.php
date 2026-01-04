<?php

namespace Tests\Feature;

use App\Models\CanvasCell;
use Livewire\Livewire;
use Tests\TestCase;

class CanvasRenderTest extends TestCase
{
    public function test_canvas_renders_with_correct_title(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('Global Toggle Canvas');
    }

    public function test_canvas_component_has_correct_dimensions(): void
    {
        Livewire::test(\App\Livewire\CanvasComponent::class)
            ->assertSet('rows', 20)
            ->assertSet('columns', 20);
    }

    public function test_canvas_loads_existing_cells(): void
    {
        CanvasCell::create([
            'row' => 0,
            'column' => 0,
            'is_checked' => true,
            'click_count' => 5,
        ]);

        Livewire::test(\App\Livewire\CanvasComponent::class)
            ->assertSet('cells.0_0.isChecked', true)
            ->assertSet('cells.0_0.clickCount', 5);
    }
}
