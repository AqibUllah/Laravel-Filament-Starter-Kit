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

class UpdateTaskTool implements Tool
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

        $task_title = $request['task'] ?? null;
        if (!$task_title) {
            return "Task title is required.";
        }

        $tenant = Filament::getTenant();
        $task = $tenant->tasks()
            ->where('title', 'LIKE', "%{$task_title}%")
            ->first();
        if (!$task) {
            return "Task '{$task_title}' not found in this team.";
        }

        /*
        |--------------------------------------------------------------------------
        | Resolve Related Models
        |--------------------------------------------------------------------------
        */

        $project_for_task = $task->project_id;
        if(!empty($request['project_for_task'])){
            $project = $this->findProject($request['project_for_task']);
            if(isset($project['error']) and !empty($project['error'])){
                return $project['error'];
            }
            $project_for_task = $project['id'];
        }

        $user_for_task = $task->assigned_to;
        if(!empty($request['user_for_task'])){
            $find_user = $this->assigned_user($request['user_for_task']);
            if(isset($find_user['error']) and !empty($find_user['error'])){
                return $find_user['error'];
            }
            $user_for_task = $find_user['id'];
        }

        /*
        |--------------------------------------------------------------------------
        | Build Update Payload
        |--------------------------------------------------------------------------
        */

        $updates = [];

        if (!empty($request['title'])) {
            $updates['title'] = $request['title'];
        }

        if (!empty($request['description'])) {
            $updates['description'] = $request['description'];
        }

        if (!empty($request['due_date'])) {
            try {
                $updates['due_date'] = Carbon::parse($request['due_date']);
            } catch (\Exception $e) {
                return "Invalid due date format.";
            }
        }

        if (!empty($request['priority'])) {
            $updates['priority'] = $request['priority'];
        }

        if (!empty($request['status'])) {
            $updates['status'] = $request['status'];
        }

        if (isset($request['estimated_hours']) && $request['estimated_hours'] !== null && $request['estimated_hours'] !== '') {
            $updates['estimated_hours'] = (double) $request['estimated_hours'];
        }

        if (isset($request['actual_hours']) && $request['actual_hours'] !== null && $request['actual_hours'] !== '') {
            $updates['actual_hours'] = (double) $request['actual_hours'];
        }

        if (!empty($request['tags']) && is_array($request['tags'])) {
            $updates['tags'] = $request['tags'];
        }

        if ($project_for_task) {
            $updates['project_id'] = $project_for_task;
        }

        if ($user_for_task) {
            $updates['assigned_to'] = $user_for_task;
        }

        /*
        |--------------------------------------------------------------------------
        | Perform Update
        |--------------------------------------------------------------------------
        */

        if (empty($updates)) {
            return "No valid fields provided to update.";
        }

        $task->update($updates);

        Notification::make()
            ->title('Task Updated')
            ->body("Task '{$task->title}' updated successfully with status '{$task->status->value}'.")
            ->info()
            ->color('primary')
            ->send();

        // logging activity
        activity()
            ->causedBy(auth()->user())
            ->performedOn($task)
            ->withProperties(['updated_by_ai' => true])
            ->log('Task updated via AI tool');


        return "Task '{$task->title}' updated successfully with status '{$task->status->value}'.";
    }

    public function findProject($project_name): ?array
    {
        $tenant = Filament::getTenant();

        if (!$tenant) {
            return null;
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
            'task' => $schema->string()->nullable(),
            'project_for_task' => $schema->string()->nullable(),
            'user_for_task' => $schema->string()->nullable(),
            'title' => $schema->string()->nullable(),
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

