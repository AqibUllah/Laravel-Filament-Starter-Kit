<?php

namespace App\Ai\Tools;

use App\Models\Project;
use Carbon\Carbon;
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

    public function parameters(): array
    {
        return [
            'name' => [
                'type' => 'string',
                'description' => 'Project name',
                'required' => true,
            ],
            'description' => [
                'type' => 'string',
                'description' => 'Project description',
                'required' => false,
            ],
        ];
    }

    /**
     * Execute the tool.
     */
    public function handle(Request $request): Stringable|string
    {

        $name = $request['name'] ?? '';
        $description = $request['description'] ?? '';
        $start_date = $request['start_date'] ?? '';
        $end_date = $request['end_date'] ?? '';
        $due_date = $request['due_date'] ?? '';
        $budget = $request['budget'] ?? '';
        $client_name = $request['client_name'] ?? '';
        $client_email = $request['client_email'] ?? '';
        $client_phone = $request['client_phone'] ?? '';
        $estimated_hours = $request['estimated_hours'] ?? '';
        $actual_hours = $request['actual_hours'] ?? '';
        $tags = $request['tags'] ?? '';
        $notes = $request['notes'] ?? '';
        $team_id = filament()->getTenant();

        $project = Project::create([
            'user_id' => Auth::id(),
            'name' => $name,
            'description' => $description ?? null,
            'start_date' => Carbon::createFromDate($start_date) ?? null,
            'end_date' => Carbon::createFromDate($end_date) ?? null,
            'due_date' => Carbon::createFromDate($due_date) ?? null,
            'budget' => (double)$budget ?? null,
            'client_name' => $client_name ?? null,
            'client_email' => $client_email ?? null,
            'client_phone' => $client_phone ?? null,
            'estimated_hours' => (double)$estimated_hours ?? null,
            'actual_hours' => (double)$actual_hours ?? null,
            'tags' => $tags ?? null,
            'notes' => $notes ?? null,
            'team_id' => $team_id ?? null,
        ]);

        return $project;
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
