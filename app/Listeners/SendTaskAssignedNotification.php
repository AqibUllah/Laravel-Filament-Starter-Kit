<?php

namespace App\Listeners;

use App\Events\TaskAssigned;
use App\Notifications\TaskAssignedNotification;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendTaskAssignedNotification implements ShouldQueue
{
    /**
     * Handle the event.
     */
    public function handle(TaskAssigned $event): void
    {
        // Notify the assigned user
        if ($event->task->assignee) {
            $event->task->assignee->notify(new TaskAssignedNotification($event->task));
        }
    }
}