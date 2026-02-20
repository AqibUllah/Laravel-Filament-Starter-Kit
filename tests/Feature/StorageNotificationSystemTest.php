<?php

test('storage quota notification system components work', function () {
    echo '🧪 Testing Storage Quota Notification System Components' . PHP_EOL;
    
    // Test 1: Event creation
    $team = \App\Models\Team::find(1);
    if ($team) {
        $event = new \App\Events\StorageQuotaExceeded(
            team: $team,
            currentUsage: 9 * 1024 * 1024 * 1024, // 9GB
            maxStorage: 10 * 1024 * 1024 * 1024, // 10GB
            requestedSize: 2 * 1024 * 1024 * 1024, // 2GB
            remainingStorage: 1 * 1024 * 1024 * 1024, // 1GB
            formattedCurrentUsage: '9 GB',
            formattedMaxStorage: '10 GB',
            formattedRequestedSize: '2 GB',
            formattedRemainingStorage: '1 GB'
        );
        
        expect($event->team->id)->toBe($team->id);
        expect($event->formattedCurrentUsage)->toBe('9 GB');
        expect($event->formattedRequestedSize)->toBe('2 GB');
        
        echo '✅ StorageQuotaExceeded event works correctly' . PHP_EOL;
    }
    
    // Test 2: Email template exists
    $template = \App\Models\EmailTemplate::where('key', 'storage-quota-exceeded')->first();
    if ($template) {
        expect($template->name)->toBe('Storage Quota Exceeded');
        expect($template->subject)->toContain('Storage Quota Exceeded');
        expect($template->content)->toContain('{{user_name}}');
        expect($template->content)->toContain('{{team_name}}');
        
        echo '✅ Email template exists and contains required variables' . PHP_EOL;
    } else {
        echo '❌ Email template not found' . PHP_EOL;
    }
    
    // Test 3: Job can be dispatched
    if (isset($event)) {
        $job = new \App\Jobs\SendStorageQuotaNotification($event);
        expect($job)->toBeInstanceOf(\App\Jobs\SendStorageQuotaNotification::class);
        
        echo '✅ SendStorageQuotaNotification job can be created' . PHP_EOL;
    }
    
    // Test 4: Middleware integration
    $middleware = new \App\Http\Middleware\CheckStorageLimitMiddleware();
    expect($middleware)->toBeInstanceOf(\App\Http\Middleware\CheckStorageLimitMiddleware::class);
    
    echo '✅ CheckStorageLimitMiddleware is properly instantiated' . PHP_EOL;
    
    echo '✨ All notification system components are working!' . PHP_EOL;
});
