<?php

namespace App\Ai\Tools;

use App\Models\Project;
use Illuminate\Contracts\JsonSchema\JsonSchema;
use Laravel\Ai\Contracts\Tool;
use Laravel\Ai\Tools\Request;
use Stringable;

class ProjectTool implements Tool
{
    /**
     * Get the description of the tool's purpose.
     */
    public function description(): Stringable|string
    {
        return 'Search project records for relevant info';
    }

    /**
     * Execute the tool.
     */
    public function handle(Request $request): Stringable|string
    {
        // Example: search by keyword
        $keyword = $arguments['keyword'] ?? '';

        return Project::query()
            ->whereNested(
                function ($q) use ($keyword) {
                    $q->where('name', 'like', "%{$keyword}%")
                    ->orWhere('description', 'like', "%{$keyword}%");
                }
            )
            ->limit(5)
            ->get();
    }

    /**
     * Get the tool's schema definition.
     */
    public function schema(JsonSchema|\Illuminate\JsonSchema\JsonSchema $schema): array
    {
        return [
            'keyword' => $schema->string()->required(),
        ];
    }
}
