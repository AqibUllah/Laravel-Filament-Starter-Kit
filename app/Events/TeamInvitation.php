<?php

namespace App\Events;

use App\Models\Team;
use App\Models\User;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class TeamInvitation
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public Team $team;

    public User $user;

    public string $invitationToken;

    /**
     * Create a new event instance.
     */
    public function __construct(Team $team, User $user, string $invitationToken)
    {
        $this->team = $team;
        $this->user = $user;
        $this->invitationToken = $invitationToken;
    }
}
