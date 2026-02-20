<?php

use App\Models\File;
use App\Models\Team;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

test('file upload records storage usage', function () {
    // Create a team and user
    $user = User::factory()->create();
    $team = Team::factory()->create(['owner_id' => $user->id]);
    
    // Authenticate and set tenant
    $this->actingAs($user);
    filament()->setTenant($team);
    
    // Create a fake file with content
    $file = UploadedFile::fake()->createWithContent('document.pdf', 'This is test content for the file');
    
    // Debug: Check file size before upload
    expect($file->getSize())->toBeGreaterThan(0);
    
    // Upload file using our service
    $fileUploadService = app(\App\Services\FileUploadService::class);
    $fileRecord = $fileUploadService->handleFileUpload($file, 'test-uploads');
    
    // Assert file record was created
    expect($fileRecord)->toBeInstanceOf(File::class);
    expect($fileRecord->team_id)->toBe($team->id);
    expect($fileRecord->size)->toBeGreaterThan(0);
    
    // Check if storage usage was recorded
    $usageService = app(\App\Services\UsageService::class);
    $usageSummary = $usageService->getUsageSummary($team);
    
    $storageUsage = $usageSummary['metrics']
        ->where('metric_name', 'storage_gb')
        ->first();
    
    expect($storageUsage)->not->toBeNull();
    expect($storageUsage->total_quantity)->toBeGreaterThan(0);
});

test('storage widget displays correct usage', function () {
    // Create a team and user
    $user = User::factory()->create();
    $team = Team::factory()->create(['owner_id' => $user->id]);
    
    // Authenticate and set tenant
    $this->actingAs($user);
    filament()->setTenant($team);
    
    // Create some storage usage
    $usageService = app(\App\Services\UsageService::class);
    $usageService->recordStorageUsage($team, 0.5); // 0.5 GB
    
    // Test the widget by calling the protected method
    $widget = new \App\Filament\Tenant\Widgets\StorageUsageWidget();
    
    // Use reflection to access protected method
    $reflection = new ReflectionClass($widget);
    $method = $reflection->getMethod('getStats');
    $method->setAccessible(true);
    
    $stats = $method->invoke($widget);
    
    expect($stats)->toHaveCount(3);
    expect($stats[0]->getDescription())->toContain('0.50 GB');
});
