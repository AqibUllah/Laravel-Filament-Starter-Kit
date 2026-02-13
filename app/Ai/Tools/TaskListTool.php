<?php

namespace App\Ai\Tools;

use App\Models\Project;
use Filament\Facades\Filament;
use Illuminate\Contracts\JsonSchema\JsonSchema;
use Laravel\Ai\Contracts\Tool;
use Laravel\Ai\Tools\Request;
use Stringable;

class TaskListTool implements Tool
{
    /**
     * Get the description of the tool's purpose.
     */
    public function description(): Stringable|string
    {
        return 'Search task records for relevant info';
    }

    /**
     * Execute the tool.
     */
    public function handle(Request $request): Stringable|string
    {
        $tenant = Filament::getTenant();

        if (!$tenant) {
            return "No active workspace found.";
        }

        $query = $tenant->tasks()->newQuery();

        /*
        |--------------------------------------------------------------------------
        | Optional Filters (AI Can Send These)
        |--------------------------------------------------------------------------
        */

        if (!empty($request['status'])) {
            $query->where('status', $request['status']);
        }

        if (!empty($request['priority'])) {
            $query->where('priority', $request['priority']);
        }

        if (!empty($request['assigned_to'])) {
            $query->whereHas('assignee', function ($q) use ($request) {
                $q->where('email', 'LIKE', "%{$request['assigned_to']}%")
                ->orWhere('name', 'LIKE', "%{$request['assigned_to']}%");
            });
        }

        if (!empty($request['project'])) {
            $query->whereHas('project', function ($q) use ($request) {
                $q->where('name', 'LIKE', "%{$request['project']}%")
                ->orWhere('description', 'LIKE', "%{$request['project']}%");
            });
        }

        if(isset($request['how_many_tasks'])){
            return $query->count();
        }

        $tasks = $query->latest()->limit(20)->get();

        if ($tasks->isEmpty()) {
            return "No tasks found with the given filters.";
        }

        /*
        |--------------------------------------------------------------------------
        | Format Output for AI
        |--------------------------------------------------------------------------
        */

        $output = "Here are the tasks:\n\n";

        $html = '<table class="min-w-full border border-gray-200 text-sm">';
        $html .= '<thead class="bg-gray-100">';
        $html .= '<tr>
                <th class="border px-3 py-2 text-left">Title</th>
                <th class="border px-3 py-2 text-left">Status</th>
                <th class="border px-3 py-2 text-left">Priority</th>
                <th class="border px-3 py-2 text-left">Due Date</th>
              </tr>';
        $html .= '</thead><tbody>';

        foreach ($tasks as $task) {
            $html .= "<tr>
                    <td class='border px-3 py-2'>{$task->title}</td>
                    <td class='border px-3 py-2'>{$task->status->value}</td>
                    <td class='border px-3 py-2'>{$task->priority->value}</td>
                    <td class='border px-3 py-2'>" . optional($task->due_date)?->format('Y-m-d') . "</td>
                  </tr>";
        }

        $html .= '</tbody></table>';

//        foreach ($tasks as $task) {
//            $output .= "- {$task->title} (Status: {$task->status->value}, Priority: {$task->priority->value})\n";
//        }

        return $html;
    }

    /**
     * Get the tool's schema definition.
     */
    public function schema(JsonSchema|\Illuminate\JsonSchema\JsonSchema $schema): array
    {
        return [
            'status' => $schema->string()->nullable(),
            'priority' => $schema->string()->nullable(),
            'assigned_to' => $schema->string()->nullable(),
            'project' => $schema->string()->nullable(),
            'how_many_tasks' => $schema->string()->nullable(),
        ];
    }
}
