<?php

use App\Enums\PriorityEnum;
use App\Enums\ProjectStatusEnum;
use App\Jobs\RecordProjectUsage;
use App\Models\Project;
use App\Models\Team;
use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Bus;

it('creates a project and computes helper values', function () {
    Bus::fake();

    $team = Team::factory()->create();
    $manager = User::factory()->create();

    $project = Project::create([
        'name' => 'Alpha',
        'start_date' => now()->subDays(10)->toDateString(),
        'due_date' => now()->addDays(10)->toDateString(),
        'status' => ProjectStatusEnum::Planning,
        'team_id' => $team->id,
        'priority' => PriorityEnum::Medium,
        'budget' => 1000,
        'progress' => 25,
        'project_manager_id' => $manager->id,
    ]);

    expect($project->exists)->toBeTrue()
        ->and($project->isCompleted())->toBeFalse()
        ->and($project->isActive())->toBeTrue()
        ->and($project->getCompletionPercentage())->toBe(25)
        ->and($project->getBudgetRemaining())->toBeFloat();

    // scope methods
    expect(Project::query()->active()->count())->toBe(1)
        ->and(Project::query()->completed()->count())->toBe(0)
        ->and(Project::query()->onHold()->count())->toBe(0)
        ->and(Project::query()->withProgress(10)->count())->toBe(1);

    // job dispatched on created
    Bus::assertDispatched(RecordProjectUsage::class);
});

it('marks a project completed and archived through helpers', function () {
    $team = Team::factory()->create();

    $project = Project::create([
        'name' => 'Bravo',
        'start_date' => now()->subDays(5)->toDateString(),
        'due_date' => now()->addDays(1)->toDateString(),
        'status' => ProjectStatusEnum::InProgress,
        'team_id' => $team->id,
        'priority' => PriorityEnum::High,
        'progress' => 50,
    ]);

    $project->markAsCompleted();
    expect($project->fresh()->status)->toBe(ProjectStatusEnum::Completed)
        ->and($project->fresh()->progress)->toBe(100)
        ->and($project->fresh()->completed_at)->not()->toBeNull();

    $project->archive();
    expect($project->fresh()->status)->toBe(ProjectStatusEnum::Archived)
        ->and($project->fresh()->archived_at)->not()->toBeNull();
});

it('computes overdue, days remaining and derived colors', function () {
    $team = Team::factory()->create();

    $overdue = Project::create([
        'name' => 'Charlie',
        'start_date' => now()->subDays(10)->toDateString(),
        'due_date' => now()->subDay()->toDateString(),
        'status' => ProjectStatusEnum::InProgress,
        'team_id' => $team->id,
        'priority' => PriorityEnum::LOW,
        'progress' => 10,
    ]);

    expect($overdue->isOverdue())->toBeTrue()
        ->and($overdue->getDaysRemaining())->toBe(0) // overdue returns null per helper
        ->and($overdue->getPriorityColor())->toBe('success')
        ->and($overdue->getStatusColor())->toBe('warning');

    $upcoming = Project::create([
        'name' => 'Delta',
        'start_date' => now()->toDateString(),
        'due_date' => now()->addDays(3)->toDateString(),
        'status' => ProjectStatusEnum::Planning,
        'team_id' => $team->id,
        'priority' => PriorityEnum::Medium,
        'progress' => 0,
    ]);

    expect($upcoming->isOverdue())->toBeFalse()
        ->and($upcoming->getDaysRemaining())->toBeInt();
});

it('can have tasks', function () {
    $project = Project::factory()->has(Task::factory()->count(3))->create();
    expect($project->tasks)->toHaveCount(3);
});


