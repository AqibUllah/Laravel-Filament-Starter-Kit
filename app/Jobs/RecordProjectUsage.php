<?php

namespace App\Jobs;

use App\Models\Project;
use App\Models\Team;
use App\Services\UsageService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class RecordProjectUsage implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        public int $teamId,
        public int $projectId,
        public float $quantity = 1,
        public float $unitPrice = 1.00
    ) {}

    public function handle(): void
    {
        $team = Team::find($this->teamId);
        if (! $team) {
            return;
        }

        $project = Project::find($this->projectId);
        app(UsageService::class)->recordProjectUsage($team, $project, $this->quantity, $this->unitPrice);
    }
}
