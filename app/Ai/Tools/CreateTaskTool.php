<?php

namespace App\Ai\Tools;

use App\Enums\PriorityEnum;
use App\Enums\TaskStatusEnum;
use App\Models\Project;
use App\Models\Task;
use Carbon\Carbon;
use Filament\Notifications\Notification;
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
        $project_for_task = null;
        if(!empty($request['project_for_task'])){
            $project = $this->findProject($request['project_for_task']);
            if(isset($project['error']) and !empty($project['error'])){
                return $project['error'];
            }
            $project_for_task = $project['id'];
        }

        $user_for_task = null;
        if(!empty($request['user_for_task'])){
            $find_user = $this->assigned_user($request['user_for_task']);
            if(isset($find_user['error']) and !empty($find_user['error'])){
                return $find_user['error'];
            }
            $user_for_task = $find_user['id'];
        }

        $user = (int)Auth::id();

        if(!$request['title']){
            return "Title for new task is required";
        }

        if(!$request['user_for_task']){
            return "User is required because i'll assign this task to a user so let me know user for task";
        }

        $title = $request['title'];
        $description = $request['description'] ?? '';
        $due_date = $request['due_date'] ?? '';
        $priority = $request['priority'] ?? PriorityEnum::Medium;
        $status = $request['status'] ?? TaskStatusEnum::Pending;
        $estimated_hours = $request['estimated_hours'] ?? '';
        $actual_hours = $request['actual_hours'] ?? '';
        $tags = $request['tags'] ?? '';
        $team_id = filament()->getTenant();

        $task = Task::create([
            'title' => $title,
            'description' => $description ?? null,
            'due_date' => Carbon::parse($due_date) ?? null,
            'assigned_by' => $user,
            'assigned_to' => $user_for_task,
            'priority' => $priority,
            'status' => $status ?? null,
            'estimated_hours' => (double)$estimated_hours ?? null,
            'actual_hours' => (double)$actual_hours ?? null,
            'tags' => $tags ?? null,
            'team_id' => $team_id ?? null,
            'project_id' => $project_for_task ?? null,
        ]);

        Notification::make()
            ->title('Task Created')
            ->body("Task '{$task->title}' created successfully with status '{$task->status->value}'.")
            ->success()
            ->color('success')
            ->send();

        // logging activity
        activity()
            ->causedBy(auth()->user())
            ->performedOn($task)
            ->withProperties(['updated_by_ai' => true])
            ->log('Task created via AI tool');

        return "Task '{$task->title}' created successfully with status '{$task->status->value}'.";

    }

    public function findProject($project_name): ?array
    {
        $tenant = Filament::getTenant();

        if (!$tenant) {
            return [
                'id' => null,
                'error' => 'No Team found',
            ];
        }

        $projects = Project::query()
            ->where('team_id', $tenant->id)
            ->where('name', 'LIKE', "%{$project_name}%")
            ->get();

        if ($projects->count() === 1) {
            return [
                'id' => $projects->first()->id,
                'error' => null
            ];
        }

        if ($projects->count() > 1) {
            // Ambiguous match
            return [
                'id' => null,
                'error' => 'Multiple projects found'
            ];
        }

        return [
            'id' => null,
            'error' => 'Oops no projects found!'
        ];
    }

    public function assigned_user($user_name_or_email): ?array
    {
        $tenant = Filament::getTenant();

        if (!$tenant) {
            return [
                'id' => null,
                'error' => 'No Team found',
            ];
        }

        $user = $tenant->members()
            ->where('email', $user_name_or_email)
            ->orWhere('name', $user_name_or_email)
            ->first();

        if ($user) {
            return [
                'id'    => $user->id,
                'error' => null
            ];
        }

        $users = $tenant->members()
            ->where('email', 'LIKE', "%{$user_name_or_email}%")
            ->orWhere('name','LIKE',$user_name_or_email)
            ->get();

        if ($users->count() === 1) {
            return  [
                'id'    => $users->first()->id,
                'error' => null
            ];
        }

        return [
            'id' => null,
            'error' => 'Multiple users found',
        ];
    }

    /**
     * Get the tool's schema definition.
     */
    public function schema(JsonSchema|\Illuminate\JsonSchema\JsonSchema $schema): array
    {
        return [
            'project_for_task' => $schema->string()->nullable(),
            'user_for_task' => $schema->string()->required(),
            'title' => $schema->string()->required(),
            'description' => $schema->string()->nullable(),
            'due_date' => $schema->string()->nullable(),
            'priority' => $schema->string()->nullable(),
            'estimated_hours' => $schema->integer()->nullable(),
            'actual_hours' => $schema->integer()->nullable(),
            'tags' => $schema->string()->nullable(),
            'status' => $schema->string()->nullable(),
        ];
    }
}

