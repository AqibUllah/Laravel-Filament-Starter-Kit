<?php

use App\Http\Controllers\Api\ApiTokenController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// API token management routes (require authentication)
Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/tokens', [ApiTokenController::class, 'index']);
    Route::post('/tokens', [ApiTokenController::class, 'store']);
    Route::put('/tokens/{tokenId}', [ApiTokenController::class, 'update']);
    Route::delete('/tokens/{tokenId}', [ApiTokenController::class, 'destroy']);
});

// API routes that require authentication and API access feature
Route::middleware(['auth:sanctum', 'api.access'])->group(function () {
    // User endpoints
    Route::get('/user', function (Request $request) {
        return response()->json($request->user());
    });

    // Team endpoints
    Route::get('/team', function (Request $request) {
        $team = \Filament\Facades\Filament::getTenant();
        return response()->json([
            'id' => $team->id,
            'name' => $team->name,
            'created_at' => $team->created_at,
        ]);
    });

    // Projects endpoints
    Route::get('/projects', function (Request $request) {
        $projects = \Filament\Facades\Filament::getTenant()->projects()
            ->with(['category', 'tasks'])
            ->latest()
            ->paginate(20);
            
        return response()->json($projects);
    });

    Route::get('/projects/{project}', function (Request $request, $id) {
        $project = \Filament\Facades\Filament::getTenant()->projects()
            ->with(['category', 'tasks'])
            ->findOrFail($id);
            
        return response()->json($project);
    });

    // Tasks endpoints
    Route::get('/tasks', function (Request $request) {
        $tasks = \Filament\Facades\Filament::getTenant()->tasks()
            ->with(['project', 'user'])
            ->latest()
            ->paginate(20);
            
        return response()->json($tasks);
    });

    Route::get('/tasks/{task}', function (Request $request, $id) {
        $task = \Filament\Facades\Filament::getTenant()->tasks()
            ->with(['project', 'user'])
            ->findOrFail($id);
            
        return response()->json($task);
    });

    // Products endpoints
    Route::get('/products', function (Request $request) {
        $products = \Filament\Facades\Filament::getTenant()->products()
            ->with('category')
            ->latest()
            ->paginate(20);
            
        return response()->json($products);
    });

    Route::get('/products/{product}', function (Request $request, $id) {
        $product = \Filament\Facades\Filament::getTenant()->products()
            ->with('category')
            ->findOrFail($id);
            
        return response()->json($product);
    });

    // Categories endpoints
    Route::get('/categories', function (Request $request) {
        $categories = \Filament\Facades\Filament::getTenant()->categories()
            ->withCount('products')
            ->latest()
            ->paginate(20);
            
        return response()->json($categories);
    });

    Route::get('/categories/{category}', function (Request $request, $id) {
        $category = \Filament\Facades\Filament::getTenant()->categories()
            ->withCount('products')
            ->findOrFail($id);
            
        return response()->json($category);
    });

    // Usage statistics
    Route::get('/usage', function (Request $request) {
        $tenant = \Filament\Facades\Filament::getTenant();
        
        return response()->json([
            'users' => $tenant->users()->count(),
            'projects' => $tenant->projects()->count(),
            'tasks' => $tenant->tasks()->count(),
            'products' => $tenant->products()->count(),
            'categories' => $tenant->categories()->count(),
        ]);
    });
});
