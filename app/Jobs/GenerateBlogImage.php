<?php

namespace App\Jobs;

use App\Models\Blog;
use Filament\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Laravel\Ai\Image;

class GenerateBlogImage implements ShouldQueue
{
    use Queueable;

    public string $imagePrompt;
    public Blog $blog;
    /**
     * Create a new job instance.
     */
    public function __construct($imagePrompt,Blog $blog)
    {
        $this->imagePrompt = $imagePrompt;
        $this->blog = $blog;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $image = Image::of($this->imagePrompt)
            ->timeout(120)
            ->generate('gemini');

        if($image){
            $image_name = time().rand(0,999999);
            $path = $image->storeAs("blogs/{$image_name}.jpg");
            $this->blog->featured_image = $path;
            $this->blog->save();

            Notification::make()
                ->title('Blog Image Created')
                ->body("Feature Image created for blog {$this->blog->title}")
                ->info()
                ->color('info')
                ->send();
        }else{
            Notification::make()
                ->title('Blog Image Not Created')
                ->body("Feature Image not created for blog {$this->blog->title}")
                ->danger()
                ->color('danger')
                ->send();
        }
    }
}
