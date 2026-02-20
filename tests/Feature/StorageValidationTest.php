<?php

use App\Services\FeatureLimiterService;

test('storage quota validation works correctly', function () {
    // Test the storage conversion functions directly
    $service = new FeatureLimiterService();
    
    // Test GB conversion
    $gbBytes = $service->convertStorageToBytes('10GB');
    expect($gbBytes)->toBe(10 * 1024 * 1024 * 1024);
    
    // Test MB conversion
    $mbBytes = $service->convertStorageToBytes('500MB');
    expect($mbBytes)->toBe(500 * 1024 * 1024);
    
    // Test TB conversion
    $tbBytes = $service->convertStorageToBytes('1TB');
    expect($tbBytes)->toBe(1 * 1024 * 1024 * 1024 * 1024);
    
    // Test default (no unit)
    $defaultBytes = $service->convertStorageToBytes('10');
    expect($defaultBytes)->toBe(10 * 1024 * 1024 * 1024);
});

test('byte formatting works correctly', function () {
    $service = new FeatureLimiterService();
    
    expect($service->formatBytes(1024))->toBe('1 KB');
    expect($service->formatBytes(1024 * 1024))->toBe('1 MB');
    expect($service->formatBytes(1024 * 1024 * 1024))->toBe('1 GB');
    expect($service->formatBytes(0))->toBe('0 B');
});
