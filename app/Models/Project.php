<?php

namespace App\Models;

use App\Enums\PriorityEnum;
use App\Enums\ProjectStatusEnum;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Project extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'description',
        'start_date',
        'due_date',
        'status',
        'team_id',
        'priority',
        'budget',
        'progress',
        'client_name',
        'client_email',
        'client_phone',
        'project_manager_id',
        'estimated_hours',
        'actual_hours',
        'tags',
        'notes',
        'completed_at',
        'archived_at',
    ];

    protected $casts = [
        'start_date' => 'date',
        'due_date' => 'date',
        'progress' => 'integer',
        'budget' => 'decimal:2',
        'estimated_hours' => 'decimal:2',
        'actual_hours' => 'decimal:2',
        'tags' => 'array',
        'completed_at' => 'datetime',
        'archived_at' => 'datetime',
        'priority' => PriorityEnum::class,
        'status' => ProjectStatusEnum::class,
    ];

    // Relationships
    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class);
    }

    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'project_user')
            ->withTimestamps()
            ->withPivot(['role', 'joined_at']);
    }

    public function projectManager(): BelongsTo
    {
        return $this->belongsTo(User::class, 'project_manager_id');
    }

    // Scopes

    #[Scope]
    public function active(Builder $query): void
    {
        $query->whereIn('status', [ProjectStatusEnum::Planning, ProjectStatusEnum::InProgress]);
    }

    #[Scope]
    public function completed(Builder $query): void
    {
        $query->where('status', ProjectStatusEnum::Completed);
    }

    #[Scope]
    public function onHold(Builder $query): void
    {
        $query->where('status', ProjectStatusEnum::OnHold);
    }

    #[Scope]
    public function overdue(Builder $query): void
    {
        $query->where('due_date', '<', now())
            ->whereNotIn('status', [ProjectStatusEnum::Completed, ProjectStatusEnum::Cancelled, ProjectStatusEnum::Archived]);
    }

    #[Scope]
    public function forUser(Builder $query, int $userId): void
    {
        $query->whereHas('users', function ($q) use ($userId) {
            $q->where('user_id', $userId);
        })->orWhere('project_manager_id', $userId);
    }

    #[Scope]
    public function highPriority(Builder $query): void
    {
        $query->where('priority', PriorityEnum::High);
    }

    #[Scope]
    public function withProgress(Builder $query, int $minProgress = 0): void
    {
        $query->where('progress', '>=', $minProgress);
    }

    // Helper Methods
    public function isOverdue(): bool
    {
        return $this->due_date && $this->due_date->isPast() &&
               !in_array($this->status, [ProjectStatusEnum::Completed, ProjectStatusEnum::Cancelled, ProjectStatusEnum::Archived]);
    }

    public function isCompleted(): bool
    {
        return $this->status === ProjectStatusEnum::Completed;
    }

    public function isActive(): bool
    {
        return in_array($this->status, [ProjectStatusEnum::Planning, ProjectStatusEnum::InProgress]);
    }

    public function getDaysRemaining(): ?int
    {
        if (!$this->due_date || $this->isCompleted()) {
            return null;
        }

        return max(0, now()->diffInDays($this->due_date, false));
    }

    public function getCompletionPercentage(): int
    {
        return $this->progress ?? 0;
    }

    public function getBudgetUsed(): float
    {
        // This would typically calculate from actual expenses
        // For now, return 0 as we don't have expense tracking
        return 0;
    }

    public function getBudgetRemaining(): ?float
    {
        if (!$this->budget) {
            return null;
        }

        return $this->budget - $this->getBudgetUsed();
    }

    public function getTotalEstimatedHours(): float
    {
        return $this->estimated_hours ?? 0;
    }

    public function getTotalActualHours(): float
    {
        return $this->actual_hours ?? 0;
    }

    public function getHoursVariance(): float
    {
        return $this->getTotalActualHours() - $this->getTotalEstimatedHours();
    }

    public function getPriorityColor(): string
    {
        return match($this->priority) {
            PriorityEnum::High => 'danger',
            PriorityEnum::Medium => 'warning',
            PriorityEnum::LOW => 'success',
            default => 'gray',
        };
    }

    public function getStatusColor(): string
    {
        return match($this->status) {
            ProjectStatusEnum::Completed => 'success',
            ProjectStatusEnum::InProgress => 'warning',
            ProjectStatusEnum::Planning => 'info',
            ProjectStatusEnum::OnHold => 'gray',
            ProjectStatusEnum::Cancelled => 'danger',
            ProjectStatusEnum::Archived => 'secondary',
        };
    }

    public function markAsCompleted(): void
    {
        $this->update([
            'status' => ProjectStatusEnum::Completed,
            'progress' => 100,
            'completed_at' => now(),
        ]);
    }

    public function archive(): void
    {
        $this->update([
            'status' => ProjectStatusEnum::Archived,
            'archived_at' => now(),
        ]);
    }

    public function restore(): void
    {
        $this->update([
            'status' => ProjectStatusEnum::Planning,
            'archived_at' => null,
        ]);
    }

    // Accessors
    public function getFormattedBudgetAttribute(): string
    {
        return $this->budget ? '$' . number_format($this->budget, 2) : 'Not set';
    }

    public function getDurationAttribute(): ?int
    {
        if (!$this->start_date || !$this->due_date) {
            return null;
        }

        return $this->start_date->diffInDays($this->due_date);
    }

    public function getIsOverdueAttribute(): bool
    {
        return $this->isOverdue();
    }

    // Boot method for model events
    protected static function boot()
    {
        parent::boot();

        static::creating(function (Project $project) {
            if (!$project->project_manager_id) {
                $project->project_manager_id = auth()->id();
            }
        });

        static::updating(function (Project $project) {
            // Auto-complete project if progress reaches 100%
            if ($project->progress >= 100 && $project->status !== ProjectStatusEnum::Completed) {
                $project->markAsCompleted();
            }
        });
    }
}
