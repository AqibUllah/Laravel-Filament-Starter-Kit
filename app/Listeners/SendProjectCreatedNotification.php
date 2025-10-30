<?php

namespace App\Listeners;

use App\Events\ProjectCreated;
use App\Models\User;
use App\Notifications\ProjectCreatedNotification;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendProjectCreatedNotification implements ShouldQueue
{
    /**
     * Handle the event.
     */
    public function handle(ProjectCreated $event): void
    {
        // Get team members who should be notified
        $teamMembers = $event->project->team->users;
        
        foreach ($teamMembers as $user) {
            $user->notify(new ProjectCreatedNotification($event->project));
        }
    }
}