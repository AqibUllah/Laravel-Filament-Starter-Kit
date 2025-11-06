<?php

use App\Enums\PriorityEnum;
use App\Enums\ProjectStatusEnum;
use App\Enums\TaskStatusEnum;

test('PriorityEnum exposes labels, colors, and icons', function () {
    expect(PriorityEnum::LOW->getLabel())->toBe('Low')
        ->and(PriorityEnum::Medium->getLabel())->toBe('Medium')
        ->and(PriorityEnum::High->getLabel())->toBe('High')
        ->and(PriorityEnum::LOW->getColor())->toBe('success')
        ->and(PriorityEnum::Medium->getColor())->toBe('warning')
        ->and(PriorityEnum::High->getColor())->toBe('danger')
        ->and(PriorityEnum::LOW->getIcon())->not()->toBeNull()
        ->and(PriorityEnum::Medium->getIcon())->not()->toBeNull()
        ->and(PriorityEnum::High->getIcon())->not()->toBeNull();
});

test('ProjectStatusEnum exposes labels, colors, and icons', function () {
    expect(ProjectStatusEnum::Planning->getLabel())->toBe('Planning')
        ->and(ProjectStatusEnum::InProgress->getLabel())->toBe('In Progress')
        ->and(ProjectStatusEnum::OnHold->getLabel())->toBe('On Hold')
        ->and(ProjectStatusEnum::Completed->getLabel())->toBe('Completed')
        ->and(ProjectStatusEnum::Cancelled->getLabel())->toBe('Cancelled')
        ->and(ProjectStatusEnum::Archived->getLabel())->toBe('Archived')
        ->and(ProjectStatusEnum::Planning->getColor())->toBe('info')
        ->and(ProjectStatusEnum::InProgress->getColor())->toBe('warning')
        ->and(ProjectStatusEnum::OnHold->getColor())->toBe('gray')
        ->and(ProjectStatusEnum::Completed->getColor())->toBe('success')
        ->and(ProjectStatusEnum::Cancelled->getColor())->toBe('danger')
        ->and(ProjectStatusEnum::Archived->getColor())->toBe('secondary')
        ->and(ProjectStatusEnum::Planning->getIcon())->not()->toBeNull()
        ->and(ProjectStatusEnum::InProgress->getIcon())->not()->toBeNull()
        ->and(ProjectStatusEnum::OnHold->getIcon())->not()->toBeNull()
        ->and(ProjectStatusEnum::Completed->getIcon())->not()->toBeNull()
        ->and(ProjectStatusEnum::Cancelled->getIcon())->not()->toBeNull()
        ->and(ProjectStatusEnum::Archived->getIcon())->not()->toBeNull();
});

test('TaskStatusEnum exposes labels, colors, and icons', function () {
    expect(TaskStatusEnum::Pending->getLabel())->toBe('Pending')
        ->and(TaskStatusEnum::InProgress->getLabel())->toBe('In Progress')
        ->and(TaskStatusEnum::Completed->getLabel())->toBe('Completed')
        ->and(TaskStatusEnum::Cancelled->getLabel())->toBe('Cancelled')
        ->and(TaskStatusEnum::Pending->getColor())->toBe('info')
        ->and(TaskStatusEnum::InProgress->getColor())->toBe('warning')
        ->and(TaskStatusEnum::Completed->getColor())->toBe('success')
        ->and(TaskStatusEnum::Cancelled->getColor())->toBe('danger')
        ->and(TaskStatusEnum::Pending->getIcon())->not()->toBeNull()
        ->and(TaskStatusEnum::InProgress->getIcon())->not()->toBeNull()
        ->and(TaskStatusEnum::Completed->getIcon())->not()->toBeNull()
        ->and(TaskStatusEnum::Cancelled->getIcon())->not()->toBeNull();
});
