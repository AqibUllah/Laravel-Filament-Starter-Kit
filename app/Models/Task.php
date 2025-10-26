<?php

namespace App\Models;

use App\Enums\PriorityEnum;
use App\Enums\TaskStatusEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'team_id',
        'assigned_by',
        'assigned_to',
        'title',
        'description',
        'due_date',
        'priority',
        'status',
        'tags',
        'estimated_hours',
        'actual_hours',
        'completed_at',
    ];

    protected function casts(): array
    {
        return [
            'due_date' => 'date',
            'tags' => 'array',
            'completed_at' => 'timestamp',
            'priority' =>  PriorityEnum::class,
            'status' =>  TaskStatusEnum::class,
        ];
    }


    // Team relationship
    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class);
    }

    // Assigner relationship
    public function assigner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_by');
    }

    // Assignee relationship
    public function assignee(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    // Scopes
    public function scopePending($query)
    {
        return $query->where('status', TaskStatusEnum::Pending);
    }

    public function scopeInProgress($query)
    {
        return $query->where('status', TaskStatusEnum::InProgress);
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', TaskStatusEnum::Completed);
    }

    public function scopeOverdue($query)
    {
        return $query->where('due_date', '<', now())->whereNotIn('status', ['completed', 'cancelled']);
    }

    public function scopeForUser($query, $userId)
    {
        return $query->where('assigned_to', $userId);
    }

    public function scopeForMe($query)
    {
        return $query->where('assigned_to', auth()->id());
    }

    // Helper methods
    public function isOverdue(): bool
    {
        return $this->due_date && $this->due_date->isPast() && !in_array($this->status, [TaskStatusEnum::Completed, TaskStatusEnum::Cancelled]);
    }

    public function markAsCompleted(?int $actualHours = null): void
    {
        $this->update([
            'status' => TaskStatusEnum::Completed,
            'completed_at' => now(),
            'actual_hours' => $actualHours ?? $this->actual_hours, // Keep existing or use provided
        ]);
    }

    public function getPriorityColor(): string
    {
        return match($this->priority) {
            'high' => 'danger',
            'medium' => 'warning',
            'low' => 'success',
            default => 'gray',
        };
    }

    public function getStatusColor(): string
    {
        return match($this->status) {
            'completed' => 'success',
            'in_progress' => 'primary',
            'cancelled' => 'danger',
            'pending' => 'warning',
            default => 'gray',
        };
    }


    // In app/Models/Task.php
    protected static function boot()
    {
        parent::boot();

        static::saving(function (Task $task) {
            if ($task->actual_hours && $task->estimated_hours) {
                // You can add business logic here
                // For example, send notification if actual hours exceed estimated by 50%
                if ($task->actual_hours > $task->estimated_hours * 1.5) {
                    // Trigger notification or log
                }
            }
        });
    }
}
