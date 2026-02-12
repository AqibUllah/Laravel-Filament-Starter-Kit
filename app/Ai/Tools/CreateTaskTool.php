<?php

namespace App\Ai\Tools;

use App\Enums\PriorityEnum;
use App\Enums\TaskStatusEnum;
use App\Models\Project;
use App\Models\Task;
use Carbon\Carbon;
use Illuminate\Contracts\JsonSchema\JsonSchema;
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
            $project_id = $this->findProject($project_for_task)->id;
        }

//        $assigned_to = $request['assigned_to'] ?? '';
//        if(isset($assigned_to)){
//            $currentTeam = Filament::getTenant();
//            $assigned_to = $currentTeam->members()->where('email','LIKE',"%{$assigned_to}%")->first()?->id;
////            $assigned_to = $this->assigned_user($request['assigned_to']);
//        }

        $title = $request['title'] ?? '';
        $description = $request['description'] ?? '';
        $due_date = $request['due_date'] ?? '';
        $priority = $request['priority'] ?? PriorityEnum::Medium;
        $status = $request['status'] ?? TaskStatusEnum::Pending;
        $estimated_hours = $request['estimated_hours'] ?? '';
        $actual_hours = $request['actual_hours'] ?? '';
        $tags = $request['tags'] ?? '';
        $team_id = filament()->getTenant();

        return Task::create([
            'title' => $title,
            'description' => $description ?? null,
            'due_date' => Carbon::createFromDate($due_date) ?? null,
            'assigned_by' => auth()->id(),
            'assigned_to' => 2,
            'priority' => $priority,
            'status' => $status ?? null,
            'estimated_hours' => (double)$estimated_hours ?? null,
            'actual_hours' => (double)$actual_hours ?? null,
            'tags' => $tags ?? null,
            'team_id' => $team_id ?? null,
            'project_id' => $project_id ?? null,
        ]);
    }

    public function findProject($project_name): Project
    {
        return Project::where('name','LIKE',"%{$project_name}%")
            ->where('team_id', Filament::getTenant()?->id)
            ->firstOrFail();
    }

    public function assigned_user($user_email): ?int
    {
        $currentTeam = Filament::getTenant();
        return $currentTeam->members()->where('email','LIKE',"%{$user_email}%")->first()?->id;
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
            'priority' => $schema->string()->nullable(),
            'estimated_hours' => $schema->integer()->nullable(),
            'actual_hours' => $schema->integer()->nullable(),
            'tags' => $schema->array()->nullable(),
            'status' => $schema->string()->nullable(),
            'project_id' => $schema->integer()->nullable(),
        ];
    }
}
