<?php

namespace App\Services;

use App\Models\File;
use Filament\Facades\Filament;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class FileUploadService
{
    public function handleFileUpload(UploadedFile $file, string $directory = 'uploads', $fileable = null): File
    {
        $team = Filament::getTenant();
        
        if (!$team) {
            throw new \Exception('No active team found');
        }

        // Generate unique filename
        $filename = Str::uuid() . '.' . $file->getClientOriginalExtension();
        $path = $file->storeAs($directory, $filename, 'public');
        
        // Create file record
        $fileRecord = File::create([
            'team_id' => $team->id,
            'filename' => $filename,
            'original_name' => $file->getClientOriginalName(),
            'path' => $path,
            'size' => $file->getSize(),
            'mime_type' => $file->getMimeType(),
            'fileable_type' => $fileable ? get_class($fileable) : null,
            'fileable_id' => $fileable ? $fileable->id : null,
            'uploaded_by' => auth()->id(),
        ]);

        return $fileRecord;
    }

    public function handleMultipleFileUpload(array $files, string $directory = 'uploads', $fileable = null): array
    {
        $fileRecords = [];
        
        foreach ($files as $file) {
            if ($file instanceof UploadedFile) {
                $fileRecords[] = $this->handleFileUpload($file, $directory, $fileable);
            }
        }
        
        return $fileRecords;
    }

    public function deleteFile(File $file): bool
    {
        // Delete from storage
        if (Storage::disk('public')->exists($file->path)) {
            Storage::disk('public')->delete($file->path);
        }
        
        // Delete record
        return $file->delete();
    }
}
