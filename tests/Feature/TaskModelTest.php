<?php

use App\Enums\PriorityEnum;
use App\Enums\TaskStatusEnum;
use App\Events\TaskAssigned;
use App\Models\Project;
use App\Models\Task;
use App\Models\Team;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;

uses(RefreshDatabase::class);

it('creates and completes a task via helper', function () {
    $team = Team::factory()->create();
    $assigner = User::factory()->create();
    $assignee = User::factory()->create();

    $project = Project::create([
        'name' => 'T-Project',
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
        'assigned_to' => $assignee->id,
        'title' => 'Prepare brief',
        'description' => 'Write kickoff brief',
        'due_date' => now()->addDay()->toDateString(),
        'priority' => PriorityEnum::High,
        'status' => TaskStatusEnum::InProgress,
        'estimated_hours' => 2,
        'actual_hours' => 1,
    ]);

    expect($task->exists)->toBeTrue()
        ->and($task->isOverdue())->toBeFalse();

    $task->markAsCompleted(3);
    $task->refresh();

    expect($task->status)->toBe(TaskStatusEnum::Completed)
        ->and($task->completed_at)->not()->toBeNull()
        ->and($task->actual_hours)->toBe(3);
});

it('fires TaskAssigned event when assignee changes', function () {
    Event::fake([TaskAssigned::class]);

    $team = Team::factory()->create();
    $assigner = User::factory()->create();
    $assigneeA = User::factory()->create();
    $assigneeB = User::factory()->create();

    $project = Project::create([
        'name' => 'T-Project-2',
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
        'assigned_to' => $assigneeA->id,
        'title' => 'Set up repo',
        'due_date' => now()->addDay()->toDateString(),
        'priority' => PriorityEnum::Medium,
        'status' => TaskStatusEnum::Pending,
    ]);

    $task->update(['assigned_to' => $assigneeB->id]);

    Event::assertDispatched(TaskAssigned::class);
});
