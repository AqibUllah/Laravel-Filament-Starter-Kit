<?php

namespace App\Jobs;

use App\Models\Team;
use App\Models\User;
use App\Services\UsageService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class RecordUserUsage implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        public int $teamId,
        public int $userId
    ) {}

    public function handle(): void
    {
        $team = Team::find($this->teamId);
        if (! $team) {
            return;
        }

        $user = User::find($this->userId);
        app(UsageService::class)->recordUserUsage($team, $user);
    }
}
