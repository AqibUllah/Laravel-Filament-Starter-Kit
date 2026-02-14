<?php

namespace App\Jobs;

use App\Models\Blog;
use Filament\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
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

        $response = Http::
        withHeaders([
            'Accept' => 'text/event-stream',
        ])->timeout(120)->post(
            'https://subnp.com/api/free/generate',
            [
                "prompt" => $this->imagePrompt,
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
            return;
        }

        $body = $response->body();

        // Split by lines
        $lines = explode("\n", $body);

        $finalData = null;

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
            return;
        }

        // Download generated image
        $imageContents = Http::get($finalData['imageUrl'])->body();

        $filename = 'blogs/' . \Str::uuid() . '.png';

        Storage::put($filename, $imageContents);

        Notification::make()
            ->title('Blog Image Created')
            ->body("Feature Image created for blog {$this->blog->title}")
            ->info()
            ->color('info')
            ->send();

        // Update blog
        $this->blog->update([
            'featured_image' => $filename,
        ]);

//        $image = Image::of($this->imagePrompt)
//            ->timeout(120)
//            ->generate('gemini');
//
//        if($image){
//            $image_name = time().rand(0,999999);
//            $path = $image->storeAs("blogs/{$image_name}.jpg");
//            $this->blog->featured_image = $path;
//            $this->blog->save();
//
//            Notification::make()
//                ->title('Blog Image Created')
//                ->body("Feature Image created for blog {$this->blog->title}")
//                ->info()
//                ->color('info')
//                ->send();
//        }else{
//            Notification::make()
//                ->title('Blog Image Not Created')
//                ->body("Feature Image not created for blog {$this->blog->title}")
//                ->danger()
//                ->color('danger')
//                ->send();
//        }
    }
}
