<?php

namespace App\Filament\Tenant\Widgets;

use App\Enums\TaskStatusEnum;
use App\Models\Task;
use Filament\Facades\Filament;
use Filament\Forms\Components\Select;
use Filament\Schemas\Schema;
use Filament\Tables\Filters\SelectFilter;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Carbon;

use App\Enums\PriorityEnum;
use App\Models\Project;
use App\Models\User;

class TaskProgressChartWidget extends ChartWidget
{
    use ChartWidget\Concerns\HasFiltersSchema;

    protected static ?int $sort = 2;
    public ?string $statusFilter = '';
    public ?string $projectFilter = '';
    public ?string $priorityFilter = '';
    public ?string $assigneeFilter = '';
    public ?string $dateRangeFilter = '30';

    public function getHeading(): string
    {
        $filters = [];

        if ($this->statusFilter) {
            $filters[] = ucfirst($this->statusFilter) . ' Tasks';
        } else {
            $filters[] = 'All Tasks';
        }

        if ($this->projectFilter) {
            $project = Project::find($this->projectFilter);
            if ($project) {
                $filters[] = "in {$project->name}";
            }
        }

        if ($this->assigneeFilter) {
            $user = User::find($this->assigneeFilter);
            if ($user) {
                $filters[] = "assigned to {$user->name}";
            }
        }

        $days = $this->dateRangeFilter ?? 30;
        $filters[] = "over last {$days} days";

        return implode(' ', $filters);
    }

    public function filtersSchema(Schema $schema): Schema
    {
        $currentTeam = Filament::getTenant();
        return $schema->components([
            Select::make('status')
                ->options(TaskStatusEnum::class),
            Select::make('project')
                ->options(Project::pluck('name', 'id')
                        ->toArray()),
            Select::make('priority')
                ->options(PriorityEnum::class),
            Select::make('assignee')
                ->options(User::whereHas('teams', function ($query) use ($currentTeam) {
                        $query->where('team_id', $currentTeam->id);
                    })->pluck('name', 'id')->toArray()),
            Select::make('dateRange')
                ->options([
                    '7' => 'Last 7 days',
                    '30' => 'Last 30 days',
                    '90' => 'Last 90 days',
                    '365' => 'Last year',
                ]),
        ]);
    }

    protected function getData(): array
    {
        $currentTeam = Filament::getTenant();

        if (!$currentTeam) {
            return [
                'datasets' => [],
                'labels' => [],
            ];
        }

        // Get task completion data for the last 30 days
        $completedTasks = Task::
            when($this->filters['project'],function ($q) {
                $q->where('project_id', $this->filters['project']);
            })
            ->when($this->filters['status'],function ($q) {
                $q->where('status', $this->filters['status']);
            })
            ->when($this->filters['priority'],function ($q) {
                $q->where('priority', $this->filters['priority']);
            })
            ->when($this->filters['assignee'],function ($q) {
                $q->where('assigned_by', $this->filters['assignee']);
            })
            ->where('updated_at', '>=', Carbon::now()->subDays(30))
            ->get()
            ->groupBy(function ($task) {
                return $task->updated_at->format('Y-m-d');
            });

        $labels = [];
        $completedData = [];

        // Generate last 30 days
        for ($i = 29; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i)->format('Y-m-d');
            $dateLabel = Carbon::now()->subDays($i)->format('M d');

            $labels[] = $dateLabel;
            $completedData[] = $completedTasks->get($date, collect())->count();
        }

        return [
            'datasets' => [
                [
                    'label' => 'Tasks Completed',
                    'data' => $completedData,
                    'backgroundColor' => 'rgba(16, 185, 129, 0.1)',
                    'borderColor' => 'rgb(16, 185, 129)',
                    'borderWidth' => 2,
                    'fill' => true,
                    'tension' => 0.4,
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }

    protected function getOptions(): array
    {
        return [
            'responsive' => true,
            'maintainAspectRatio' => false,
            'plugins' => [
                'legend' => [
                    'display' => true,
                ],
            ],
            'scales' => [
                'y' => [
                    'beginAtZero' => true,
                    'ticks' => [
                        'stepSize' => 1,
                    ],
                ],
            ],
        ];
    }
}
