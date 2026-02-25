<?php

namespace App\Filament\Tenant\Widgets;

use App\Models\Project;
use App\Models\Subscription;
use App\Models\Task;
use Filament\Facades\Filament;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class QuickSummaryWidget extends BaseWidget
{
    protected ?string $heading = 'Quick Summary';

    protected static ?int $sort = 4;

    protected int|string|array $columnSpan = 'full';

    protected function getStats(): array
    {
        $currentTeam = Filament::getTenant();

        if (! $currentTeam) {
            return [];
        }

        // Get summary data
        $totalProjects = Project::count();
        $activeProjects = Project::query()->active()->count();
        $completedProjects = Project::query()->completed()->count();
        $overdueProjects = Project::query()->overdue()->count();

        $totalTasks = Task::query()->forMe()->count();
        $completedTasks = Task::query()->forMe()->completed()->count();
        $overdueTasks = Task::query()->forMe()->overdue()->count();
        $myPendingTasks = Task::query()->forMe()->pending()->count();

        $currentSubscription = Subscription::where('team_id', $currentTeam->id)
            ->where('status', 'active')
            ->first();
        $currentPlan = $currentSubscription?->plan;

        $totalEstimated = Task::query()->forMe()->sum('estimated_hours');
        $totalActual = Task::query()->forMe()->sum('actual_hours');
        $efficiency = $totalEstimated > 0 ? ($totalActual / $totalEstimated) * 100 : 0;

        return [
            Stat::make('Projects Overview', $totalProjects)
                ->description($activeProjects.' active, '.$completedProjects.' completed, '.$overdueProjects.' overdue')
                ->descriptionIcon('heroicon-m-folder-open')
                ->color($overdueProjects > 0 ? 'warning' : 'success')
                ->url(fn (): string => route('filament.tenant.pages.project-dashboard', ['tenant' => filament()->getTenant()]))
                ->extraAttributes([
                    'class' => 'cursor-pointer transition-all duration-300 ease-in-out hover:scale-105 hover:shadow-xl hover:shadow-blue-500/25 bg-gradient-to-br from-blue-50 to-blue-100 dark:from-blue-900/20 dark:to-blue-800/20 rounded-xl p-4 hover:border-blue-300 dark:hover:border-blue-600',
                ]),

            Stat::make('Tasks Overview', $totalTasks)
                ->description($myPendingTasks.' pending, '.$completedTasks.' completed, '.$overdueTasks.' overdue')
                ->descriptionIcon('heroicon-m-clipboard-document-list')
                ->color($overdueTasks > 0 ? 'warning' : 'success')
                ->url(fn (): string => route('filament.tenant.pages.task-dashboard', ['tenant' => filament()->getTenant()]))
                ->extraAttributes([
                    'class' => 'cursor-pointer transition-all duration-300 ease-in-out hover:scale-105 hover:shadow-xl hover:shadow-green-500/25 bg-gradient-to-br from-green-50 to-emerald-100 dark:from-green-900/20 dark:to-emerald-800/20 rounded-xl p-4 hover:border-green-300 dark:hover:border-green-600',
                ]),

            Stat::make('Time Tracking', number_format($totalEstimated, 1).'h')
                ->description('Estimated: '.number_format($totalEstimated, 1).'h | Actual: '.number_format($totalActual, 1).'h | Efficiency: '.number_format($efficiency, 1).'%')
                ->descriptionIcon('heroicon-m-clock')
                ->color($efficiency >= 90 ? 'success' : ($efficiency >= 70 ? 'warning' : 'danger'))
                ->extraAttributes([
                    'class' => 'transition-all duration-300 ease-in-out hover:scale-105 hover:shadow-xl hover:shadow-purple-500/25 bg-gradient-to-br from-purple-50 to-violet-100 dark:from-purple-900/20 dark:to-violet-800/20 rounded-xl p-4 hover:border-purple-300 dark:hover:border-purple-600',
                ]),

            Stat::make('Subscription Status', $currentPlan?->name ?? 'No Plan')
                ->description($currentPlan ? '$'.$currentPlan->price.'/'.$currentPlan->interval.' | '.($currentSubscription ? 'Active' : 'Inactive') : 'No active subscription')
                ->descriptionIcon('heroicon-m-credit-card')
                ->color($currentSubscription ? 'success' : 'danger')
                ->url(fn (): string => route('filament.tenant.pages.plans-dashboard', ['tenant' => filament()->getTenant()]))
                ->extraAttributes([
                    'class' => 'cursor-pointer transition-all duration-300 ease-in-out hover:scale-105 hover:shadow-xl hover:shadow-amber-500/25 bg-gradient-to-br from-amber-50 to-orange-100 dark:from-amber-900/20 dark:to-orange-800/20 rounded-xl p-4 hover:border-amber-300 dark:hover:border-amber-600',
                ]),
        ];
    }

    protected function getColumns(): int
    {
        return 2;
    }
}
