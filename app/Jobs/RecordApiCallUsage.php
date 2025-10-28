<?php

namespace App\Jobs;

use App\Models\Team;
use App\Services\UsageService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class RecordApiCallUsage implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        public int $teamId,
        public string $endpoint,
        public int $responseTimeMs
    ) {}

    public function handle(): void
    {
        $team = Team::find($this->teamId);
        if (! $team) {
            return;
        }

        app(UsageService::class)->recordApiCall($team, $this->endpoint, $this->responseTimeMs);
    }
}


