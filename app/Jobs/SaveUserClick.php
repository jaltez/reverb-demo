<?php

namespace App\Jobs;

use App\Models\VoteOption;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SaveUserClick implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        protected VoteOption $voteOption
    ) {}

    public function handle(): void
    {
        $this->voteOption->increment('count');
    }
}
