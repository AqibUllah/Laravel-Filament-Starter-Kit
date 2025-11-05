<?php

namespace App\Listeners;

use App\Events\TaskAssigned;
use App\Notifications\TaskAssignedNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\DB;

class SendTaskAssignedNotification implements ShouldQueue
{
    /**
     * Handle the event.
     */
    public function handle(TaskAssigned $event): void
    {
        // Get the task's team_id to scope settings correctly
        $teamId = $event->task->team_id;
        \Illuminate\Support\Facades\Log::info('SendTaskAssignedNotification: teamId', ['teamId' => $teamId]);
        
        if (!$teamId) {
            return;
        }

        // Query settings directly for the specific team
        $settings = $this->getSettingsForTeam($teamId);
        \Illuminate\Support\Facades\Log::info('SendTaskAssignedNotification: settings', ['settings' => $settings]);

        // Check if notifications for task assignment are enabled
        if (!($settings['notify_on_task_assign'] ?? false)) {
            return;
        }

        // Notify the assigned user
        if ($event->task->assignee) {
            $event->task->assignee->notify(new TaskAssignedNotification($event->task));
        }
    }

    /**
     * Get settings for a specific team
     */
    protected function getSettingsForTeam(int $teamId): array
    {
        // Get properties for the specific team
        $properties = DB::table('settings')
            ->where('group', 'tenant_general')
            ->where('tenant_id', $teamId)
            ->get(['name', 'payload'])
            ->mapWithKeys(function ($item) {
                return [$item->name => json_decode($item->payload, true)];
            })
            ->toArray();

        // If no team-specific settings found, try to get defaults (tenant_id = null)
        if (empty($properties)) {
            $properties = DB::table('settings')
                ->where('group', 'tenant_general')
                ->whereNull('tenant_id')
                ->get(['name', 'payload'])
                ->mapWithKeys(function ($item) {
                    return [$item->name => json_decode($item->payload, true)];
                })
                ->toArray();
        }

        return $properties;
    }
}
