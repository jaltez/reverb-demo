<?php

namespace Database\Seeders;

use App\Models\VoteOption;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        foreach (['fire', 'earth', 'air', 'water'] as $option) {
            VoteOption::create([
                'name' => $option,
            ]);
        }
    }
}
