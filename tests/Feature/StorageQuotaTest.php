<?php

use App\Models\Team;
use App\Models\User;
use App\Services\FeatureLimiterService;

test('storage quota prevents oversized uploads', function () {
    // Create a team with 10GB storage limit
    $user = User::factory()->create();
    $team = Team::factory()->create(['owner_id' => $user->id]);
    
    // Set up subscription with 10GB storage
    $team->subscription->plan->features = collect([
        (object) ['name' => 'Storage', 'value' => '10GB'],
    ]);
    
    // Simulate current usage of 8GB
    $currentUsage = 8 * 1024 * 1024 * 1024; // 8GB in bytes
    
    // Mock the current usage by creating files
    for ($i = 0; $i < 8; $i++) {
        $team->files()->create([
            'filename' => "test-file-{$i}.pdf",
            'original_name' => "test-file-{$i}.pdf",
            'path' => "test-file-{$i}.pdf",
            'size' => 1024 * 1024 * 1024, // 1GB each
            'mime_type' => 'application/pdf',
            'uploaded_by' => $user->id,
        ]);
    }
    
    $limiter = app(FeatureLimiterService::class)->forTenant($team);
    
    // Test with 3GB file (should be allowed - 8GB + 3GB = 11GB, but we have 10GB limit)
    $allowedFileSize = 3 * 1024 * 1024 * 1024; // 3GB
    expect($limiter->canUseStorage($allowedFileSize))->toBeTrue();
    
    // Test with 5GB file (should be blocked - 8GB + 5GB = 13GB > 10GB)
    $blockedFileSize = 5 * 1024 * 1024 * 1024; // 5GB
    expect($limiter->canUseStorage($blockedFileSize))->toBeFalse();
    
    // Verify remaining storage calculation
    expect($limiter->getRemainingStorage())->toBe(2 * 1024 * 1024 * 1024); // 2GB remaining
});

test('storage quota allows uploads within limit', function () {
    // Create a team with 10GB storage limit
    $user = User::factory()->create();
    $team = Team::factory()->create(['owner_id' => $user->id]);
    
    // Set up subscription with 10GB storage
    $team->subscription->plan->features = collect([
        (object) ['name' => 'Storage', 'value' => '10GB'],
    ]);
    
    // Simulate current usage of 2GB
    for ($i = 0; $i < 2; $i++) {
        $team->files()->create([
            'filename' => "test-file-{$i}.pdf",
            'original_name' => "test-file-{$i}.pdf",
            'path' => "test-file-{$i}.pdf",
            'size' => 1024 * 1024 * 1024, // 1GB each
            'mime_type' => 'application/pdf',
            'uploaded_by' => $user->id,
        ]);
    }
    
    $limiter = app(FeatureLimiterService::class)->forTenant($team);
    
    // Test with 5GB file (should be allowed - 2GB + 5GB = 7GB < 10GB)
    $allowedFileSize = 5 * 1024 * 1024 * 1024; // 5GB
    expect($limiter->canUseStorage($allowedFileSize))->toBeTrue();
    
    // Test with 8GB file (should be blocked - 2GB + 8GB = 10GB, exactly at limit)
    $exactLimitFileSize = 8 * 1024 * 1024 * 1024; // 8GB
    expect($limiter->canUseStorage($exactLimitFileSize))->toBeFalse(); // At limit, should be blocked
    
    // Verify remaining storage calculation
    expect($limiter->getRemainingStorage())->toBe(8 * 1024 * 1024 * 1024); // 8GB remaining
});
