<?php

namespace App\Ai\Tools;

use App\Models\Project;
use Carbon\Carbon;
use Illuminate\Contracts\JsonSchema\JsonSchema;
use Laravel\Ai\Contracts\Tool;
use Laravel\Ai\Tools\Request;
use Stringable;

class ProjectAnalyticsTool implements Tool
{
    /**
     * Get the description of the tool's purpose.
     */
    public function description(): Stringable|string
    {
        return 'Get analytics data about projects including counts, trends, and activity.';
    }

    /**
     * Execute the tool.
     */
    public function handle(Request $request): Stringable|string
    {
        return match ($request['type']) {

            'monthly_count' => [
                'count' => Project::whereMonth(
                    'created_at',
                    Carbon::now()->month
                )->count(),
            ],

            'overdue' => [
                'projects' => Project::query()->overdue()->get(['id', 'name', 'due_date']),
            ],

            'weekly_summary' => [
                'created' => Project::whereBetween(
                    'created_at',
                    [now()->subWeek(), now()]
                )->count(),
            ],

            default => 'Invalid analytics type',
        };
    }

    /**
     * Get the tool's schema definition.
     */
    public function schema(JsonSchema|\Illuminate\JsonSchema\JsonSchema $schema): array
    {
        return [
            'type' => $schema->string()->description('Type of analytics: monthly_count, overdue, weekly_summary')->nullable(),
        ];
    }
}
