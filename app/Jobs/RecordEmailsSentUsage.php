<?php

namespace App\Jobs;

use App\Models\Team;
use App\Services\UsageService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class RecordEmailsSentUsage implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        public int $teamId,
        public int $campaignId,
        public int $quantity = 1,
        public float $unitPrice = 0.01
    ) {}

    public function handle(): void
    {
        $team = Team::find($this->teamId);
        if (! $team) {
            return;
        }

        app(UsageService::class)->recordUsage(
            $team,
            'emails_sent',
            $this->quantity,
            $this->unitPrice,
            null,
            ['campaign' => $this->campaignId]
        );
    }
}
