<?php

namespace App\Ai\Tools;

use App\Models\Project;
use Carbon\Carbon;
use Filament\Facades\Filament;
use Filament\Notifications\Notification;
use Illuminate\Contracts\JsonSchema\JsonSchema;
use Illuminate\Support\Facades\Auth;
use Laravel\Ai\Contracts\Tool;
use Laravel\Ai\Tools\Request;
use Stringable;

class CreateProjectTool implements Tool
{
    /**
     * Get the description of the tool's purpose.
     */
    public function description(): Stringable|string
    {
        return 'Create a new project for the authenticated user.';
    }

    /**
     * Execute the tool.
     */
    public function handle(Request $request): Stringable|string
    {
        $tenant = Filament::getTenant();

        if (!$tenant) {
            return "No active team found.";
        }

        $name = trim($request['name'] ?? '');

        if (!$name) {
            return "Project name is required.";
        }

        /*
        |--------------------------------------------------------------------------
        | Prevent Duplicate Project Names in Same Workspace
        |--------------------------------------------------------------------------
        */

        $exists = Project::query()
            ->where('team_id', $tenant->id)
            ->where('name', $name)
            ->exists();

        if ($exists) {
            return "A project named '{$name}' already exists in this workspace.";
        }

        /*
        |--------------------------------------------------------------------------
        | Prepare Data Safely
        |--------------------------------------------------------------------------
        */

        $data = [
            'user_id' => Auth::id(),
            'name' => $name,
            'team_id' => $tenant->id,
        ];

        if (!empty($request['description'])) {
            $data['description'] = $request['description'];
        }

        if (!empty($request['start_date'])) {
            try {
                $data['start_date'] = Carbon::parse($request['start_date']);
            } catch (\Exception $e) {
                return "Invalid start date or format.";
            }
        }

        if (!empty($request['end_date'])) {
            try {
                $data['end_date'] = Carbon::parse($request['end_date']);
            } catch (\Exception $e) {
                return "Invalid end date or format.";
            }
        }

        if (!empty($request['due_date'])) {
            try {
                $data['due_date'] = Carbon::parse($request['due_date']);
            } catch (\Exception $e) {
                return "Invalid due date or format.";
            }
        }

        if ($request['budget'] !== null && $request['budget'] !== '') {
            $data['budget'] = (double) $request['budget'];
        }

        if (!empty($request['client_name'])) {
            $data['client_name'] = $request['client_name'];
        }

        if (!empty($request['client_email'])) {
            $data['client_email'] = $request['client_email'];
        }

        if (!empty($request['client_phone'])) {
            $data['client_phone'] = $request['client_phone'];
        }

        if ($request['estimated_hours'] !== null && $request['estimated_hours'] !== '') {
            $data['estimated_hours'] = (double) $request['estimated_hours'];
        }

        if ($request['actual_hours'] !== null && $request['actual_hours'] !== '') {
            $data['actual_hours'] = (double) $request['actual_hours'];
        }

        if (!empty($request['tags']) && is_array($request['tags'])) {
            $data['tags'] = $request['tags'];
        }

        if (!empty($request['notes'])) {
            $data['notes'] = $request['notes'];
        }

        /*
        |--------------------------------------------------------------------------
        | Create Project
        |--------------------------------------------------------------------------
        */

        $project = Project::create($data);

        Notification::make()
            ->title('Project Created')
            ->body("Project '{$project->name}' created successfully")
            ->success()
            ->color('success')
            ->send();

        // logging activity
        activity()
            ->causedBy(auth()->user())
            ->performedOn($project)
            ->withProperties(['updated_by_ai' => true])
            ->log('Project created via AI tool');

        return "Project '{$project->name}' created successfully in this workspace.";
    }

    /**
     * Get the tool's schema definition.
     */
    public function schema(JsonSchema|\Illuminate\JsonSchema\JsonSchema $schema): array
    {
        return [
            'name' => $schema->string()->required(),
            'description' => $schema->string()->nullable(),
            'start_date' => $schema->string()->required(),
            'end_date' => $schema->string()->required(),
            'due_date' => $schema->string()->required(),
            'budget' => $schema->integer()->required(),
            'client_name' => $schema->string()->nullable(),
            'client_email' => $schema->string()->nullable(),
            'client_phone' => $schema->string()->nullable(),
            'estimated_hours' => $schema->integer()->nullable(),
            'actual_hours' => $schema->integer()->nullable(),
            'tags' => $schema->array()->nullable(),
            'notes' => $schema->string()->nullable(),
        ];
    }
}
