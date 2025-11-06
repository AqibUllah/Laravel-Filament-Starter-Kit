<?php

namespace App\Listeners;

use App\Events\TeamInvitation;
use App\Notifications\TeamInvitationNotification;
use App\Settings\TenantGeneralSettings;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendTeamInvitationNotification implements ShouldQueue
{
    /**
     * Handle the event.
     */
    public function handle(TeamInvitation $event): void
    {
        $settings = app(TenantGeneralSettings::class);

        // Check if email notifications are enabled globally
        if (! $settings->email_notifications_enabled) {
            return;
        }

        // Notify the invited user
        $event->user->notify(new TeamInvitationNotification($event->team, $event->invitationToken));
    }
}
