<?php

namespace App\Ai\Tools;

use App\Models\Project;
use App\Models\Task;
use Carbon\Carbon;
use Illuminate\Contracts\JsonSchema\JsonSchema;
use Illuminate\Support\Facades\Auth;
use Laravel\Ai\Contracts\Tool;
use Laravel\Ai\Tools\Request;
use Stringable;
use Filament\Facades\Filament;

class CreateTaskTool implements Tool
{
    /**
     * Get the description of the tool's purpose.
     */
    public function description(): Stringable|string
    {
        return 'Create a new task for the authenticated user.';
    }

    /**
     * Execute the tool.
     */
    public function handle(Request $request): Stringable|string
    {

        $project_for_task = $request['project_for_task'] ?? '';
        if(isset($project_for_task)){
            $project_id = $this->findProject($project_for_task);
        }

        $users_for_task = $request['users_for_task'] ?? '';
        if(isset($project_for_task)){
            $assigned_user_ids = $this->assigned_users($users_for_task);
        }

        $title = $request['title'] ?? '';
        $description = $request['description'] ?? '';
        $due_date = $request['due_date'] ?? '';
        $priority = $request['priority'] ?? '';
        $status = $request['status'] ?? '';
        $estimated_hours = $request['estimated_hours'] ?? '';
        $actual_hours = $request['actual_hours'] ?? '';
        $tags = $request['tags'] ?? '';
        $team_id = filament()->getTenant();

        $project = Task::create([
            'assigned_by' => Auth::id(),
            'title' => $title,
            'description' => $description ?? null,
            'due_date' => Carbon::createFromDate($due_date) ?? null,
            'assigned_to' => $assigned_user_ids ?? null,
            'priority' => $priority ?? null,
            'status' => $status ?? null,
            'estimated_hours' => (double)$estimated_hours ?? null,
            'actual_hours' => (double)$actual_hours ?? null,
            'tags' => $tags ?? null,
            'team_id' => $team_id ?? null,
            'project_id' => $project_id ?? null,
        ]);

        return $project;
    }

    public function findProject($project_name): Project
    {
        return Project::where('name','LIKE',"%{$project_name}%")->firstOrFail();
    }

    public function assigned_users($user_name): Project
    {
        $currentTeam = Filament::getTenant();
        return $currentTeam->members()->where('name','LIKE',"%{$user_name}%")->pluck('user_id');
    }

    /**
     * Get the tool's schema definition.
     */
    public function schema(JsonSchema|\Illuminate\JsonSchema\JsonSchema $schema): array
    {
        return [
            'title' => $schema->string()->required(),
            'description' => $schema->string()->nullable(),
            'due_date' => $schema->string()->nullable(),
            'assigned_by' => $schema->integer()->nullable(),
            'assigned_to' => $schema->array()->required(),
            'priority' => $schema->string()->nullable(),
            'estimated_hours' => $schema->integer()->nullable(),
            'actual_hours' => $schema->integer()->nullable(),
            'tags' => $schema->array()->nullable(),
            'status' => $schema->string()->nullable(),
            'project_id' => $schema->integer()->nullable(),
        ];
    }
}
