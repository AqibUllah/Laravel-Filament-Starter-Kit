<?php

namespace App\Http\Middleware;

use App\Events\StorageQuotaExceeded;
use App\Jobs\SendStorageQuotaNotification;
use App\Services\FeatureLimiterService;
use Closure;
use Illuminate\Http\Request;

class CheckStorageLimitMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // Only check for file upload requests
        if (!$this->isFileUploadRequest($request)) {
            return $next($request);
        }

        $user = $request->user();
        if (!$user || !$user->tenant) {
            return $next($request);
        }

        $tenant = $user->tenant;
        $limiter = app(FeatureLimiterService::class)->forTenant($tenant);

        // Get uploaded file sizes from request
        $totalUploadSize = $this->getUploadSize($request);

        if ($totalUploadSize > 0 && !$limiter->canUseStorage($totalUploadSize)) {
            $currentUsage = $limiter->getCurrentStorageUsage();
            $maxStorage = $limiter->getFeatureLimit('max_storage') * 1024 * 1024; // Convert MB to bytes
            $remainingStorage = max(0, $maxStorage - $currentUsage);

            // Create and dispatch storage quota exceeded event
            $event = new StorageQuotaExceeded(
                team: $tenant,
                currentUsage: $currentUsage,
                maxStorage: $maxStorage,
                requestedSize: $totalUploadSize,
                remainingStorage: $remainingStorage,
                formattedCurrentUsage: $this->formatBytes($currentUsage),
                formattedMaxStorage: $this->formatBytes($maxStorage),
                formattedRequestedSize: $this->formatBytes($totalUploadSize),
                formattedRemainingStorage: $this->formatBytes($remainingStorage)
            );

            // Send Filament notification and email
            SendStorageQuotaNotification::dispatch($event);

            return response()->json([
                'message' => 'Storage quota exceeded. You have ' . $this->formatBytes($remainingStorage) . ' remaining.',
                'current_usage' => $this->formatBytes($currentUsage),
                'limit' => $this->formatBytes($maxStorage),
                'requested' => $this->formatBytes($totalUploadSize),
                'remaining' => $this->formatBytes($remainingStorage),
                'notification_sent' => true,
            ], 422);
        }

        return $next($request);
    }

    private function isFileUploadRequest(Request $request): bool
    {
        // Check if this request contains ANY file uploads
        // This covers all resources: Users (avatar), Categories (image), 
        // Products (images), Blogs (featured_image), Projects (attachments), etc.
        return !empty($request->allFiles());
    }

    private function getUploadSize(Request $request): int
    {
        $totalSize = 0;

        // Get ALL uploaded files from the request
        $allFiles = $request->allFiles();
        
        foreach ($allFiles as $fileOrArray) {
            if (is_array($fileOrArray)) {
                // Handle array of files (e.g., multiple attachments)
                foreach ($fileOrArray as $file) {
                    if ($file && $file->isValid()) {
                        $totalSize += $file->getSize();
                    }
                }
            } else {
                // Handle single file (e.g., avatar, image, featured_image)
                if ($fileOrArray && $fileOrArray->isValid()) {
                    $totalSize += $fileOrArray->getSize();
                }
            }
        }

        return $totalSize;
    }

    private function formatBytes(int $bytes): string
    {
        $units = ['B', 'KB', 'MB', 'GB'];
        $bytes = max(0, $bytes);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);

        $bytes /= (1 << (10 * $pow));

        return round($bytes, 2) . ' ' . $units[$pow];
    }
}
