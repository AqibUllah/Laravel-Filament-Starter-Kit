<?php

namespace App\Ai\Tools;

use Illuminate\Contracts\JsonSchema\JsonSchema;
use Illuminate\Support\Str;
use Laravel\Ai\Attributes\Provider;
use Laravel\Ai\Audio;
use Laravel\Ai\Contracts\Tool;
use Laravel\Ai\Tools\Request;
use Stringable;

#[Provider('elven')]
class TextToAudioTool implements Tool
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
        return 'A description of the tool.';
    }

    /**
     * Execute the tool.
     */
    public function handle(Request $request): Stringable|string
    {
        $audio = Audio::of($this->prompt)
            ->generate('eleven');
        $audio_path = 'audios/' . Str::uuid() . '-audio.mp3';
        $audio->storePubliclyAs($audio_path);
        return "this is your generate audio: ".$audio_path;
    }

    /**
     * Get the tool's schema definition.
     */
    public function schema(JsonSchema|\Illuminate\JsonSchema\JsonSchema $schema): array
    {
        return [
            'prompt' => $schema->string()->required(),
        ];
    }
}
