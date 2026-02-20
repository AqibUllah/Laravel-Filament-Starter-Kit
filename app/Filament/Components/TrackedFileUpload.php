<?php

namespace App\Filament\Components;

use App\Services\FileUploadService;
use Filament\Forms\Components\FileUpload as BaseFileUpload;
use Illuminate\Support\Facades\Storage;

class TrackedFileUpload extends BaseFileUpload
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->afterStateUpdated(function (TrackedFileUpload $component, $state) {
            if ($state && is_array($state)) {
                $fileUploadService = app(FileUploadService::class);
                
                foreach ($state as $file) {
                    if (is_string($file) && Storage::disk('public')->exists($file)) {
                        // This is a newly uploaded file that needs to be tracked
                        $fileInfo = pathinfo($file);
                        $filename = $fileInfo['basename'];
                        $originalName = $filename; // Filament stores original name in metadata
                        
                        // Get the file size
                        $size = Storage::disk('public')->size($file);
                        
                        // Get the current model from the form context
                        $model = $component->getRecord();
                        
                        if ($model && method_exists($model, 'team_id') && $model->team_id) {
                            \App\Models\File::create([
                                'team_id' => $model->team_id,
                                'filename' => $filename,
                                'original_name' => $originalName,
                                'path' => $file,
                                'size' => $size,
                                'mime_type' => Storage::disk('public')->mimeType($file),
                                'fileable_type' => get_class($model),
                                'fileable_id' => $model->id,
                                'uploaded_by' => auth()->id(),
                            ]);
                        }
                    }
                }
            }
        });
    }
}
