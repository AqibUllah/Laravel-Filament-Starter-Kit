<?php

namespace App\Ai\Tools;

use App\Ai\Agents\SupportBot;
use App\Enums\BlogStatusEnum;
use App\Enums\PriorityEnum;
use App\Enums\TaskStatusEnum;
use App\Jobs\GenerateBlogImage;
use App\Models\Blog;
use App\Models\Project;
use App\Models\Task;
use Carbon\Carbon;
use Filament\Notifications\Notification;
use Illuminate\Contracts\JsonSchema\JsonSchema;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Laravel\Ai\Contracts\Tool;
use Laravel\Ai\Image;
use Laravel\Ai\Tools\Request;
use Stringable;
use Filament\Facades\Filament;

class CreateBlogTool implements Tool
{
    /**
     * Get the description of the tool's purpose.
     */
    public function description(): Stringable|string
    {
        return 'Create a blog for the authenticated user.';
    }

    /**
     * Execute the tool.
     */
    public function handle(Request $request): Stringable|string
    {

        $user = Auth::user();

        $topic = $request['topic'];
        $tone = $request['tone'] ?? 'professional';

        if(!isset($topic)){
            return "Kindly provide blog topic";
        }

        $status = BlogStatusEnum::Draft;
        if(isset($request['status'])){
            $status = $request['status'];
        }

        $team = Filament::getTenant();


        $prompt = "
        Write a {$tone} blog post about {$topic}.
        Return:
        - Title
        - Short excerpt (2 sentences)
        - Full detailed content in HTML format.
        ";

        $bot = new SupportBot($user,$prompt);
        $conversation = $bot->forUser($user);
        $content = $conversation->prompt($prompt);


        $featured_image_prompt = "
        generate a {$tone} and visually appealing feature image for a blog post about '{$topic}'.";

        // Basic parsing (you can improve later)
        $title = $topic;
        $excerpt = Str::limit(strip_tags($content), 150);

        $blog = Blog::create([
            'team_id' => $team->id,
            'user_id' => $user->id,
            'title' => $title,
            'slug' => Str::slug($title) . '-' . uniqid(),
            'excerpt' => $excerpt,
            'content' => $content,
            'status' => $status,
        ]);

        GenerateBlogImage::dispatch($featured_image_prompt,$blog);

        Notification::make()
            ->title('Blog Created')
            ->body("Blog {$status->value} created successfully with ID: {$blog->id}")
            ->success()
            ->color('success')
            ->send();

        // logging activity
        activity()
            ->causedBy(auth()->user())
            ->performedOn($blog)
            ->withProperties(['updated_by_ai' => true])
            ->log('Blog created via AI tool');

        return "Blog {$status->value} created successfully with ID: {$blog->id}";

    }

    /**
     * Get the tool's schema definition.
     */
    public function schema(JsonSchema|\Illuminate\JsonSchema\JsonSchema $schema): array
    {
        return [
            'tone' => $schema->string()->nullable(),
            'topic' => $schema->string()->required(),
            'excerpt' => $schema->string()->nullable(),
            'content' => $schema->string()->nullable(),
            'published_at' => $schema->string()->nullable(),
            'status' => $schema->string()->nullable(),
        ];
    }
}

