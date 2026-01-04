<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CanvasCell extends Model
{
    /** @use HasFactory<\Database\Factories\CanvasCellFactory> */
    use HasFactory;

    protected $fillable = [
        'row',
        'column',
        'is_checked',
        'click_count',
        'color',
    ];

    protected $casts = [
        'is_checked' => 'boolean',
        'click_count' => 'integer',
    ];

    public function toggle(): void
    {
        $this->is_checked = !$this->is_checked;
        $this->click_count++;
        $this->save();
    }

    public function scopeChecked(Builder $query): Builder
    {
        return $query->where('is_checked', true);
    }

    public function scopeUnchecked(Builder $query): Builder
    {
        return $query->where('is_checked', false);
    }

    public function scopeInRow(Builder $query, int $row): Builder
    {
        return $query->where('row', $row);
    }
}
