<?php

namespace App\Services;

use App\Models\Coupon;
use App\Models\Plan;
use App\Models\Team;
use App\Models\Subscription;
use Illuminate\Support\Facades\Validator;

class CouponService
{
    /**
     * Validate a coupon code for a specific team and plan
     */
    public function validateCoupon(string $couponCode, Team $team, Plan $plan): array
    {
        $coupon = Coupon::where('code', $couponCode)->first();

        if (!$coupon) {
            return [
                'valid' => false,
                'message' => 'Invalid coupon code.',
                'coupon' => null,
            ];
        }

        if (!$coupon->isValid()) {
            return [
                'valid' => false,
                'message' => 'This coupon is no longer valid.',
                'coupon' => $coupon,
            ];
        }

        if (!$coupon->canBeUsedByTeam($team)) {
            return [
                'valid' => false,
                'message' => 'This coupon is not available for your team.',
                'coupon' => $coupon,
            ];
        }

        if (!$coupon->canBeUsedForPlan($plan)) {
            return [
                'valid' => false,
                'message' => 'This coupon is not valid for the selected plan.',
                'coupon' => $coupon,
            ];
        }

        // Check if team has already used this coupon
        $existingSubscription = Subscription::where('team_id', $team->id)
            ->where('coupon_id', $coupon->id)
            ->exists();

        if ($existingSubscription) {
            return [
                'valid' => false,
                'message' => 'This coupon has already been used by your team.',
                'coupon' => $coupon,
            ];
        }

        return [
            'valid' => true,
            'message' => 'Coupon is valid.',
            'coupon' => $coupon,
        ];
    }

    /**
     * Calculate discount amount for a coupon and plan price
     */
    public function calculateDiscount(Coupon $coupon, float $planPrice): array
    {
        $discountAmount = $coupon->calculateDiscount($planPrice);
        $finalAmount = max(0, $planPrice - $discountAmount);

        return [
            'original_price' => $planPrice,
            'discount_amount' => $discountAmount,
            'final_amount' => $finalAmount,
            'savings_percentage' => $planPrice > 0 ? round(($discountAmount / $planPrice) * 100, 2) : 0,
        ];
    }

    /**
     * Apply coupon to a subscription
     */
    public function applyCouponToSubscription(Subscription $subscription, Coupon $coupon): bool
    {
        try {
            $planPrice = $subscription->plan->price;
            $discountData = $this->calculateDiscount($coupon, $planPrice);

            $subscription->update([
                'coupon_id' => $coupon->id,
                'discount_amount' => $discountData['discount_amount'],
                'final_amount' => $discountData['final_amount'],
            ]);

            // Increment coupon usage
            $coupon->incrementUsage();

            return true;
        } catch (\Exception $e) {
            \Log::error('Failed to apply coupon to subscription: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Get available coupons for a team and plan
     */
    public function getAvailableCoupons(Team $team, Plan $plan): \Illuminate\Database\Eloquent\Collection
    {
        return Coupon::active()
            ->forTeam($team->id)
            ->forPlan($plan->id)
            ->where(function ($query) use ($team) {
                $query->whereNull('usage_limit')
                      ->orWhereRaw('used_count < usage_limit');
            })
            ->orderBy('created_at', 'desc')
            ->get();
    }

    /**
     * Check if a coupon can be used by a team
     */
    public function canUseCoupon(Coupon $coupon, Team $team): bool
    {
        // Check if team has already used this coupon
        $hasUsed = Subscription::where('team_id', $team->id)
            ->where('coupon_id', $coupon->id)
            ->exists();

        return !$hasUsed && $coupon->canBeUsedByTeam($team);
    }

    /**
     * Get coupon usage statistics for a team
     */
    public function getCouponUsageStats(Team $team): array
    {
        $totalCouponsUsed = Subscription::where('team_id', $team->id)
            ->whereNotNull('coupon_id')
            ->count();

        $totalSavings = Subscription::where('team_id', $team->id)
            ->whereNotNull('coupon_id')
            ->sum('discount_amount');

        return [
            'total_coupons_used' => $totalCouponsUsed,
            'total_savings' => $totalSavings,
            'average_savings_per_coupon' => $totalCouponsUsed > 0 ? $totalSavings / $totalCouponsUsed : 0,
        ];
    }
}
