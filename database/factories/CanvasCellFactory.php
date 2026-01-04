<?php

namespace Database\Factories;

use App\Models\CanvasCell;
use Illuminate\Database\Eloquent\Factories\Factory;

class CanvasCellFactory extends Factory
{
    protected $model = CanvasCell::class;

    public function definition(): array
    {
        return [
            'row' => $this->faker->numberBetween(0, 19),
            'column' => $this->faker->numberBetween(0, 19),
            'is_checked' => $this->faker->boolean(30),
            'click_count' => $this->faker->numberBetween(0, 10),
        ];
    }
}
