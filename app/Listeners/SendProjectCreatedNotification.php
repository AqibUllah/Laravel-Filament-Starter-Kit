<?php

namespace App\Listeners;

use App\Events\ProjectCreated;
use App\Models\User;
use App\Notifications\ProjectCreatedNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\DB;

class SendProjectCreatedNotification implements ShouldQueue
{
    /**
     * Handle the event.
     */
    public function handle(ProjectCreated $event): void
    {
        // Get the project's team_id to scope settings correctly
        $teamId = $event->project->team_id;
        
        if (!$teamId) {
            return;
        }

        // Query settings directly for the specific team
        $settings = $this->getSettingsForTeam($teamId);
        
        // Check if email notifications are enabled globally
        if (!($settings['email_notifications_enabled'] ?? false)) {
            return;
        }
        
        // Check if notifications for project changes are enabled
        if (!($settings['notify_on_project_changes'] ?? false)) {
            return;
        }
        
        // Get team members who should be notified
        $teamMembers = $event->project->team->users;
        
        foreach ($teamMembers as $user) {
            $user->notify(new ProjectCreatedNotification($event->project));
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