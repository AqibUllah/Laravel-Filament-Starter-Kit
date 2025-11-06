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

beforeEach(function () {
    $this->user = User::factory()->create();
    $this->team = Team::factory()->create([
        'owner_id' => User::factory(),
    ]);
});

function seedTenantSetting(int $teamId, string $name, array $payload): void
{
    DB::table('settings')->updateOrInsert(
        [
            'group' => 'tenant_general',
            'name' => $name,
            'tenant_id' => $teamId,
        ],
        [
            'payload' => json_encode($payload),
            'locked' => false,
            'created_at' => now(),
            'updated_at' => now(),
        ]
    );
}

it('sends project created notifications when enabled via settings', function () {
    Notification::fake();

    $user = User::factory()->create();

    // Attach user to team
    $this->team->members()->attach($user);

    seedTenantSetting($this->team->id, 'email_notifications_enabled', ['value' => true]);
    seedTenantSetting($this->team->id, 'notify_on_project_changes', ['value' => true]);

    $project = Project::create([
        'name' => 'New Project',
        'start_date' => now()->toDateString(),
        'due_date' => now()->addDay()->toDateString(),
        'status' => \App\Enums\ProjectStatusEnum::Planning,
        'team_id' => $this->team->id,
        'priority' => \App\Enums\PriorityEnum::Medium,
    ]);

    // The ProjectCreated event should be automatically dispatched via the model's $dispatchesEvents
    // But we'll explicitly dispatch it to ensure it runs
    event(new ProjectCreated($project));

    // The notification should be sent to the team member
    Notification::assertSentTo($user, ProjectCreatedNotification::class,
        function ($notification) use ($project) {
            return $notification->project->id === $project->id;
        });
});

it('sends task assigned notifications when enabled via settings', function () {
    Notification::fake();

    $this->team = Team::factory()->create([
        'owner_id' => User::factory(),
    ]);
    $assigner = User::factory()->create();
    $assignee = User::factory()->create();

    seedTenantSetting($this->team->id, 'notify_on_task_assign', ['value' => true]);

    $project = Project::create([
        'name' => 'Notif-Proj',
        'start_date' => now()->toDateString(),
        'due_date' => now()->addDay()->toDateString(),
        'status' => \App\Enums\ProjectStatusEnum::Planning,
        'team_id' => $this->team->id,
        'priority' => \App\Enums\PriorityEnum::Medium,
    ]);

    $task = Task::create([
        'team_id' => $this->team->id,
        'project_id' => $project->id,
        'assigned_by' => $assigner->id,
        'assigned_to' => $assignee->id,
        'title' => 'Assign me',
        'due_date' => now()->addDay()->toDateString(),
        'priority' => \App\Enums\PriorityEnum::LOW,
        'status' => \App\Enums\TaskStatusEnum::Pending,
    ]);

    event(new TaskAssigned($task));

    Notification::assertSentTo($assignee, TaskAssignedNotification::class,
        function ($notification) use ($task) {
            return $notification->task->id === $task->id;
        });
});
