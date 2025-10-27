<?php

namespace Database\Seeders;

use App\Models\Coupon;
use App\Models\Admin;
use Illuminate\Database\Seeder;

class CouponSeeder extends Seeder
{
    /**
     * Run the database seeder.
     */
    public function run(): void
    {
        // Get the first admin user to be the creator
        $admin = Admin::first();

        // Global coupons (available to all teams)
        $globalCoupons = [
            [
                'code' => 'WELCOME20',
                'name' => 'Welcome Discount',
                'description' => '20% off your first subscription',
                'type' => 'percentage',
                'value' => 20.00,
                'minimum_amount' => 0,
                'maximum_discount' => 50.00,
                'usage_limit' => 100,
                'valid_from' => now(),
                'valid_until' => now()->addMonths(6),
                'is_active' => true,
                'team_id' => null,
                'plan_id' => null,
                'created_by' => $admin?->id,
            ],
            [
                'code' => 'SAVE50',
                'name' => 'Fixed Discount',
                'description' => '$50 off any subscription',
                'type' => 'fixed',
                'value' => 50.00,
                'minimum_amount' => 100.00,
                'maximum_discount' => null,
                'usage_limit' => 50,
                'valid_from' => now(),
                'valid_until' => now()->addMonths(3),
                'is_active' => true,
                'team_id' => null,
                'plan_id' => null,
                'created_by' => $admin?->id,
            ],
            [
                'code' => 'EARLYBIRD',
                'name' => 'Early Bird Special',
                'description' => '15% off for early adopters',
                'type' => 'percentage',
                'value' => 15.00,
                'minimum_amount' => 0,
                'maximum_discount' => 100.00,
                'usage_limit' => 200,
                'valid_from' => now(),
                'valid_until' => now()->addMonths(2),
                'is_active' => true,
                'team_id' => null,
                'plan_id' => null,
                'created_by' => $admin?->id,
            ],
        ];

        foreach ($globalCoupons as $couponData) {
            Coupon::create($couponData);
        }

        // Team-specific coupons (example for first team)
        $firstTeam = \App\Models\Team::first();
        if ($firstTeam) {
            $teamCoupons = [
                [
                    'code' => 'TEAMSPECIAL',
                    'name' => 'Team Special',
                    'description' => 'Special discount for this team',
                    'type' => 'percentage',
                    'value' => 25.00,
                    'minimum_amount' => 0,
                    'maximum_discount' => 75.00,
                    'usage_limit' => 10,
                    'valid_from' => now(),
                    'valid_until' => now()->addMonths(1),
                    'is_active' => true,
                    'team_id' => $firstTeam->id,
                    'plan_id' => null,
                    'created_by' => $admin?->id,
                ],
            ];

            foreach ($teamCoupons as $couponData) {
                Coupon::create($couponData);
            }
        }

        $this->command->info('Coupons seeded successfully!');
    }
}