<?php

namespace App\Services;

use App\Models\Category;
use App\Models\Product;
use App\Models\Team;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

class MarketplaceService
{
    /**
     * Get public products from all tenants with caching
     */
    public function getPublicProducts(int $perPage = 12, array $filters = [], int $page = null): Collection|LengthAwarePaginator
    {
        return Cache::remember('marketplace_public_products_' . md5(serialize($filters + ['page' => $page])), now()->addMinutes(30), function () use ($perPage, $filters, $page) {

            $query = Product::query()
                ->with(['category', 'team'])
                ->where('is_public', true)
                ->where('is_active', true)
                ->whereHas('team', function (Builder $query) {
                    $query->where('status', true);
                });

            // Apply filters
            if (!empty($filters['category'])) {
                $query->where('category_id', $filters['category']);
            }

            if (!empty($filters['search'])) {
                $query->where(function (Builder $query) use ($filters) {
                    $query->where('name', 'like', '%' . $filters['search'] . '%')
                          ->orWhere('description', 'like', '%' . $filters['search'] . '%')
                          ->orWhere('sku', 'like', '%' . $filters['search'] . '%');
                });
            }

            if (!empty($filters['team'])) {
                $query->where('team_id', $filters['team']);
            }

            if (!empty($filters['min_price'])) {
                $query->where('price', '>=', $filters['min_price']);
            }

            if (!empty($filters['max_price'])) {
                $query->where('price', '<=', $filters['max_price']);
            }

            // Apply sorting
            if (!empty($filters['sort'])) {
                switch ($filters['sort']) {
                    case 'price_low':
                        $query->orderBy('price', 'asc');
                        break;
                    case 'price_high':
                        $query->orderBy('price', 'desc');
                        break;
                    case 'name':
                        $query->orderBy('name', 'asc');
                        break;
                    case 'latest':
                    default:
                        $query->orderBy('created_at', 'desc');
                        break;
                }
            } else {
                // Default sort: featured first, then by created_at
                $query->orderBy('is_featured', 'desc')
                      ->orderBy('created_at', 'desc');
            }

            // Handle pagination
            if ($page) {
                return $query->paginate($perPage, ['*'], 'page', $page);
            }

            return $query->paginate($perPage);
        });
    }

    /**
     * Get public categories from all tenants
     */
    public function getPublicCategories(): Collection
    {
        return Cache::remember('marketplace_public_categories', now()->addHours(6), function () {
            return Category::query()
                ->where('is_active', true)
                ->whereHas('products', function (Builder $query) {
                    $query->where('is_public', true)
                          ->where('is_active', true);
                })
                ->withCount(['products' => function (Builder $query) {
                    $query->where('is_public', true)
                          ->where('is_active', true);
                }])
                ->orderBy('name')
                ->get();
        });
    }

    /**
     * Get public teams (tenants) with active products
     */
    public function getPublicTeams(): Collection
    {
        return Cache::remember('marketplace_public_teams', now()->addHours(6), function () {
            return Team::query()
                ->where('status', true)
                ->whereHas('products', function (Builder $query) {
                    $query->where('is_public', true)
                          ->where('is_active', true);
                })
                ->withCount(['products' => function (Builder $query) {
                    $query->where('is_public', true)
                          ->where('is_active', true);
                }])
                ->orderBy('name')
                ->get();
        });
    }

    /**
     * Get featured products from all tenants
     */
    public function getFeaturedProducts(int $limit = 8): Collection
    {
        return Cache::remember('marketplace_featured_products', now()->addMinutes(60), function () use ($limit) {
            return Product::query()
                ->with(['category', 'team'])
                ->where('is_public', true)
                ->where('is_active', true)
                ->where('is_featured', true)
                ->whereHas('team', function (Builder $query) {
                    $query->where('is_active', true);
                })
                ->orderBy('created_at', 'desc')
                ->limit($limit)
                ->get();
        });
    }

    /**
     * Get related products
     */
    public function getRelatedProducts(Product $product, int $limit = 4): Collection
    {
        return Product::query()
            ->with(['category', 'team'])
            ->where('is_public', true)
            ->where('is_active', true)
            ->where('id', '!=', $product->id)
            ->where(function (Builder $query) use ($product) {
                // Same category or similar products
                $query->where('category_id', $product->category_id)
                      ->orWhere('name', 'like', '%' . substr($product->name, 0, 3) . '%');
            })
            ->whereHas('team', function (Builder $query) {
                $query->where('is_active', true);
            })
            ->inRandomOrder()
            ->limit($limit)
            ->get();
    }

    /**
     * Get tenant info for product display
     */
    public function getTenantInfo(int $teamId): ?array
    {
        $team = \App\Models\Team::find($teamId);

        if (!$team || !$team->is_active) {
            return null;
        }

        return [
            'id' => $team->id,
            'name' => $team->name,
            'slug' => $team->slug,
            'logo' => $team->logo,
            'currency' => $team->currency ?? 'USD',
            'rating' => $this->getTenantRating($teamId),
            'total_products' => $team->products()->where('is_public', true)->count(),
        ];
    }

    /**
     * Calculate tenant rating based on reviews/sales
     */
    private function getTenantRating(int $teamId): float
    {
        // This could be enhanced with actual review system
        return Cache::remember("tenant_rating_{$teamId}", now()->addHours(24), function () use ($teamId) {
            // Simple rating based on number of public products
            $productCount = \App\Models\Team::find($teamId)?->products()->where('is_public', true)->count() ?? 0;

            if ($productCount >= 50) return 5.0;
            if ($productCount >= 25) return 4.5;
            if ($productCount >= 10) return 4.0;
            if ($productCount >= 5) return 3.5;
            if ($productCount >= 1) return 3.0;

            return 2.5;
        });
    }

    /**
     * Clear marketplace cache
     */
    public function clearCache(): void
    {
        Cache::forget('marketplace_public_categories');
        Cache::forget('marketplace_featured_products');

        // Clear all product cache keys
        $cacheKeys = Cache::getRedis()?->keys('marketplace_public_products_*') ?? [];
        foreach ($cacheKeys as $key) {
            Cache::forget($key);
        }
    }
}
