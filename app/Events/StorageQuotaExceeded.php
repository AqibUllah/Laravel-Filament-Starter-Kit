<?php

namespace App\Events;

use App\Models\Team;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class StorageQuotaExceeded
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(
        public Team $team,
        public int $currentUsage,
        public int $maxStorage,
        public int $requestedSize,
        public int $remainingStorage,
        public string $formattedCurrentUsage,
        public string $formattedMaxStorage,
        public string $formattedRequestedSize,
        public string $formattedRemainingStorage
    ) {}

    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('team.' . $this->team->id),
        ];
    }
}
