<?php

namespace App\Ai\Tools;

use App\Models\Project;
use Filament\Notifications\Notification;
use Illuminate\Contracts\JsonSchema\JsonSchema;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Laravel\Ai\Contracts\Tool;
use Laravel\Ai\Image;
use Laravel\Ai\Tools\Request;
use Stringable;

class GenerateImageTool implements Tool
{
    public string $prompt;
    public function __construct($prompt)
    {
        $this->prompt = $prompt;
    }

    /**
     * Get the description of the tool's purpose.
     */
    public function description(): Stringable|string
    {
        return 'Generate image base on user requirements';
    }

    /**
     * Execute the tool.
     */
    public function handle(Request $request): Stringable|string
    {
        $response = Http::withHeaders([
            'Accept' => 'text/event-stream',
        ])->timeout(120)->post(
            'https://subnp.com/api/free/generate',
            [
                "prompt" => $this->prompt,
                "model" => "magic",
            ]
        );
        if (! $response->successful()) {
            logger()->error('Image generation failed', [
                'response' => $response->body()
            ]);
            Notification::make()
                ->title('Blog Image Not Created')
                ->body("Feature Image not created for blog {$this->blog->title}")
                ->danger()
                ->color('danger')
                ->send();
            return "Image not created! try again";
        }

        // Split by lines
        $lines = explode("\n", $response->body());

        $finalData = null|'';

        foreach ($lines as $line) {
            if (str_starts_with($line, 'data:')) {
                $json = trim(str_replace('data:', '', $line));
                $decoded = json_decode($json, true);

                if (isset($decoded['status']) && $decoded['status'] === 'complete') {
                    $finalData = $decoded;
                }
            }
        }

        if (! $finalData || empty($finalData['imageUrl'])) {
            logger()->error('Final image URL not found');
            Notification::make()
                ->title('Blog Image Not Created')
                ->body("Feature Image not created for blog {$this->blog->title}")
                ->danger()
                ->color('danger')
                ->send();
            return "final image url loading failed";
        }

        // Download generated image
        $imageContents = Http::get($finalData['imageUrl'])->body();

        $filename = 'images/' . \Str::uuid() . '.png';

        Storage::disk('public')->put($filename, $imageContents);

        return "image created : ".storage_path($filename);

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
