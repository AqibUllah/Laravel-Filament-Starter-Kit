<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use App\Models\Plan;
use App\Models\Team;
use App\Services\CouponService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class CouponController extends Controller
{
    protected CouponService $couponService;

    public function __construct(CouponService $couponService)
    {
        $this->couponService = $couponService;
    }

    /**
     * Validate a coupon code
     */
    public function validate(Request $request): JsonResponse
    {
        $request->validate([
            'coupon_code' => 'required|string',
            'plan_id' => 'required|exists:plans,id',
        ]);

        $team = auth()->user()->currentTeam;
        $plan = Plan::findOrFail($request->plan_id);

        if (!$team) {
            return response()->json([
                'valid' => false,
                'message' => 'No team selected',
            ], 400);
        }

        $result = $this->couponService->validateCoupon($request->coupon_code, $team, $plan);

        if ($result['valid']) {
            $discountData = $this->couponService->calculateDiscount($result['coupon'], $plan->price);
            
            return response()->json([
                'valid' => true,
                'message' => $result['message'],
                'coupon' => [
                    'id' => $result['coupon']->id,
                    'code' => $result['coupon']->code,
                    'name' => $result['coupon']->name,
                    'description' => $result['coupon']->description,
                    'type' => $result['coupon']->type,
                    'value' => $result['coupon']->value,
                    'formatted_discount' => $result['coupon']->getFormattedDiscount(),
                ],
                'discount' => $discountData,
            ]);
        }

        return response()->json([
            'valid' => false,
            'message' => $result['message'],
        ], 400);
    }

    /**
     * Get available coupons for a team and plan
     */
    public function available(Request $request): JsonResponse
    {
        $request->validate([
            'plan_id' => 'required|exists:plans,id',
        ]);

        $team = auth()->user()->currentTeam;
        $plan = Plan::findOrFail($request->plan_id);

        if (!$team) {
            return response()->json([
                'coupons' => [],
            ]);
        }

        $coupons = $this->couponService->getAvailableCoupons($team, $plan);

        return response()->json([
            'coupons' => $coupons->map(function ($coupon) use ($plan) {
                $discountData = $this->couponService->calculateDiscount($coupon, $plan->price);
                
                return [
                    'id' => $coupon->id,
                    'code' => $coupon->code,
                    'name' => $coupon->name,
                    'description' => $coupon->description,
                    'type' => $coupon->type,
                    'value' => $coupon->value,
                    'formatted_discount' => $coupon->getFormattedDiscount(),
                    'discount' => $discountData,
                    'valid_until' => $coupon->valid_until,
                    'usage_limit' => $coupon->usage_limit,
                    'used_count' => $coupon->used_count,
                ];
            }),
        ]);
    }

    /**
     * Get coupon usage statistics for the current team
     */
    public function stats(): JsonResponse
    {
        $team = auth()->user()->currentTeam;

        if (!$team) {
            return response()->json([
                'stats' => [
                    'total_coupons_used' => 0,
                    'total_savings' => 0,
                    'average_savings_per_coupon' => 0,
                ],
            ]);
        }

        $stats = $this->couponService->getCouponUsageStats($team);

        return response()->json([
            'stats' => $stats,
        ]);
    }
}
