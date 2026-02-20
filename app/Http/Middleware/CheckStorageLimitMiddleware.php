<?php

namespace App\Http\Middleware;

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
            
            return response()->json([
                'message' => 'Storage quota exceeded. You have ' . $this->formatBytes($remainingStorage) . ' remaining.',
                'current_usage' => $this->formatBytes($currentUsage),
                'limit' => $this->formatBytes($maxStorage),
                'requested' => $this->formatBytes($totalUploadSize),
                'remaining' => $this->formatBytes($remainingStorage),
            ], 422);
        }

        return $next($request);
    }

    private function isFileUploadRequest(Request $request): bool
    {
        // Check if this is a file upload request
        return $request->hasFile('attachments') || 
               $request->hasFile('files') || 
               $request->hasFile('file') ||
               str_contains($request->path(), 'projects') && $request->isMethod('POST');
    }

    private function getUploadSize(Request $request): int
    {
        $totalSize = 0;

        // Check for multiple files
        if ($request->hasFile('attachments')) {
            $files = $request->file('attachments');
            if (is_array($files)) {
                foreach ($files as $file) {
                    if ($file && $file->isValid()) {
                        $totalSize += $file->getSize();
                    }
                }
            } elseif ($files && $files->isValid()) {
                $totalSize += $files->getSize();
            }
        }

        // Check for single file
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            if ($file && $file->isValid()) {
                $totalSize += $file->getSize();
            }
        }

        // Check for files array
        if ($request->hasFile('files')) {
            $files = $request->file('files');
            if (is_array($files)) {
                foreach ($files as $file) {
                    if ($file && $file->isValid()) {
                        $totalSize += $file->getSize();
                    }
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
