<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\FeatureLimiterService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ApiTokenController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $user = $request->user();
        $tokens = $user->tokens()->orderBy('created_at', 'desc')->get();

        return response()->json([
            'tokens' => $tokens->map(function ($token) {
                return [
                    'id' => $token->id,
                    'name' => $token->name,
                    'abilities' => $token->abilities,
                    'created_at' => $token->created_at,
                    'expires_at' => $token->expires_at,
                    'last_used_at' => $token->last_used_at,
                ];
            }),
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'abilities' => 'array',
            'abilities.*' => 'string',
            'expires_at' => 'nullable|date|after:now',
        ]);

        $user = $request->user();
        
        // Check if user has API access
        $tenant = $user->teams()->first();
        if (!$tenant) {
            return response()->json([
                'message' => 'No tenant found for this user.',
            ], 403);
        }

        $limiter = app(FeatureLimiterService::class)->forTenant($tenant);
        $apiAccess = $limiter->getFeatureLimit('API Access');

        if (!$apiAccess) {
            return response()->json([
                'message' => 'API access is not available on your current plan. Please upgrade to create API tokens.',
                'feature' => 'API Access',
                'current_plan' => $tenant->currentPlan->name ?? 'Unknown',
            ], 403);
        }

        // Limit number of tokens per user (optional)
        $tokenCount = $user->tokens()->count();
        if ($tokenCount >= 5) {
            return response()->json([
                'message' => 'You have reached the maximum number of API tokens (5). Please delete an existing token first.',
            ], 422);
        }

        $abilities = $request->abilities ?? ['*'];

        $token = $user->createToken(
            $request->name,
            $abilities,
            $request->expires_at ? now()->parse($request->expires_at) : null
        );

        return response()->json([
            'message' => 'API token created successfully.',
            'token' => $token->plainTextToken,
            'token_info' => [
                'id' => $token->accessToken->id,
                'name' => $token->accessToken->name,
                'abilities' => $token->accessToken->abilities,
                'expires_at' => $token->accessToken->expires_at,
            ],
        ], 201);
    }

    public function destroy(Request $request, string $tokenId): JsonResponse
    {
        $user = $request->user();
        
        $token = $user->tokens()->findOrFail($tokenId);
        $token->delete();

        return response()->json([
            'message' => 'API token deleted successfully.',
        ]);
    }

    public function update(Request $request, string $tokenId): JsonResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'abilities' => 'array',
            'abilities.*' => 'string',
        ]);

        $user = $request->user();
        $token = $user->tokens()->findOrFail($tokenId);

        $token->update([
            'name' => $request->name,
            'abilities' => $request->abilities ?? $token->abilities,
        ]);

        return response()->json([
            'message' => 'API token updated successfully.',
            'token' => [
                'id' => $token->id,
                'name' => $token->name,
                'abilities' => $token->abilities,
                'created_at' => $token->created_at,
                'expires_at' => $token->expires_at,
                'last_used_at' => $token->last_used_at,
            ],
        ]);
    }
}
