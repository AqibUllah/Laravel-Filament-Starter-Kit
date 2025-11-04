<?php

use App\Events\ProjectCreated;
use App\Events\TaskAssigned;
use App\Models\Project;
use App\Models\Task;
use App\Models\Team;
use App\Models\User;
use App\Notifications\ProjectCreatedNotification;
use App\Notifications\TaskAssignedNotification;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;

uses(RefreshDatabase::class);

function seedTenantSetting(int $teamId, string $name, array $payload): void {
    DB::table('settings')->insert([
        'group' => 'tenant_general',
        'name' => $name,
        'payload' => json_encode($payload),
        'tenant_id' => $teamId,
        'locked' => false,
        'created_at' => now(),
        'updated_at' => now(),
    ]);
}

it('sends project created notifications when enabled via settings', function () {
    Notification::fake();

    $team = Team::factory()->create();
    $users = User::factory()->count(2)->create();

    // Attach users to team via relationship if exists; otherwise, skip
    if (method_exists($team, 'users')) {
        $team->users()->sync($users->pluck('id')->all());
    }

    seedTenantSetting($team->id, 'email_notifications_enabled', ['value' => true]);
    seedTenantSetting($team->id, 'notify_on_project_changes', ['value' => true]);

    $project = Project::create([
        'name' => 'New Project',
        'start_date' => now()->toDateString(),
        'due_date' => now()->addDay()->toDateString(),
        'status' => \App\Enums\ProjectStatusEnum::Planning,
        'team_id' => $team->id,
        'priority' => \App\Enums\PriorityEnum::Medium,
    ]);

    // Explicitly dispatch if relationship users() was not attached
    event(new ProjectCreated($project));

    foreach ($users as $user) {
        Notification::assertSentTo($user, ProjectCreatedNotification::class);
    }
});

it('sends task assigned notifications when enabled via settings', function () {
    Notification::fake();

    $team = Team::factory()->create();
    $assigner = User::factory()->create();
    $assignee = User::factory()->create();

    seedTenantSetting($team->id, 'notify_on_task_assign', ['value' => true]);

    $project = Project::create([
        'name' => 'Notif-Proj',
        'start_date' => now()->toDateString(),
        'due_date' => now()->addDay()->toDateString(),
        'status' => \App\Enums\ProjectStatusEnum::Planning,
        'team_id' => $team->id,
        'priority' => \App\Enums\PriorityEnum::Medium,
    ]);

    $task = Task::create([
        'team_id' => $team->id,
        'project_id' => $project->id,
        'assigned_by' => $assigner->id,
        'title' => 'Assign me',
        'due_date' => now()->addDay()->toDateString(),
        'priority' => \App\Enums\PriorityEnum::LOW,
        'status' => \App\Enums\TaskStatusEnum::Pending,
    ]);

    $task->update(['assigned_to' => $assignee->id]);

    Notification::assertSentTo($assignee, TaskAssignedNotification::class);
});


