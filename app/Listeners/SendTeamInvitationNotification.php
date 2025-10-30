<?php

namespace App\Listeners;

use App\Events\TeamInvitation;
use App\Notifications\TeamInvitationNotification;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendTeamInvitationNotification implements ShouldQueue
{
    /**
     * Handle the event.
     */
    public function handle(TeamInvitation $event): void
    {
        // Notify the invited user
        $event->user->notify(new TeamInvitationNotification($event->team, $event->invitationToken));
    }
}