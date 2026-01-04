<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('canvas_cells', function (Blueprint $table): void {
            $table->id();
            $table->unsignedInteger('row')->index();
            $table->unsignedInteger('column')->index();
            $table->boolean('is_checked')->default(false)->index();
            $table->unsignedInteger('click_count')->default(0);
            $table->timestamps();

            $table->unique(['row', 'column']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('canvas_cells');
    }
};
