<?php

namespace App\Observers;

use App\Models\File;
use App\Jobs\RecordStorageUsage;

class FileObserver
{
    /**
     * Handle the File "created" event.
     */
    public function created(File $file): void
    {
        // Record storage usage when a file is uploaded
        if ($file->team_id && $file->size > 0) {
            $sizeInGb = $file->size / (1024 * 1024 * 1024); // Convert bytes to GB
            RecordStorageUsage::dispatch($file->team_id, $sizeInGb);
        }
    }

    /**
     * Handle the File "deleted" event.
     */
    public function deleted(File $file): void
    {
        // Note: We don't subtract storage usage on deletion as per typical billing practices
        // Storage is usually billed for the period, not refunded when files are deleted
    }

    /**
     * Handle the File "updated" event.
     */
    public function updated(File $file): void
    {
        // If file size changed, record the difference
        if ($file->isDirty('size') && $file->team_id) {
            $oldSize = $file->getOriginal('size');
            $newSize = $file->size;
            $difference = ($newSize - $oldSize) / (1024 * 1024 * 1024); // Convert bytes to GB
            
            if ($difference > 0) {
                // Only record additional usage, don't subtract
                RecordStorageUsage::dispatch($file->team_id, $difference);
            }
        }
    }

    /**
     * Handle the File "restored" event.
     */
    public function restored(File $file): void
    {
        // Record storage usage when a file is restored
        if ($file->team_id && $file->size > 0) {
            $sizeInGb = $file->size / (1024 * 1024 * 1024); // Convert bytes to GB
            RecordStorageUsage::dispatch($file->team_id, $sizeInGb);
        }
    }

    /**
     * Handle the File "force deleted" event.
     */
    public function forceDeleted(File $file): void
    {
        // Same as deleted - we don't subtract storage usage
    }
}
