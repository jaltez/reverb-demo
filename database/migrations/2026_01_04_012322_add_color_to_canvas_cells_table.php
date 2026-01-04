<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('canvas_cells', function (Blueprint $table) {
            $table->string('color')->nullable()->after('click_count');
        });
    }

    public function down(): void
    {
        Schema::table('canvas_cells', function (Blueprint $table) {
            $table->dropColumn('color');
        });
    }
};
