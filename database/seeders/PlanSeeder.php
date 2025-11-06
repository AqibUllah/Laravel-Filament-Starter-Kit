<?php

namespace Database\Seeders;

use App\Models\Plan;
use Illuminate\Database\Seeder;

class PlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $plans = [
            [
                'name' => 'Starter',
                'description' => 'Perfect for small teams getting started',
                'price' => 0.00,
                'interval' => 'month',
                'trial_days' => 14,
                'sort_order' => 1,
                'is_active' => true,
                'is_featured' => false,
                'stripe_product_id' => 'prod_THIE1sdI6LpM7g',
                'stripe_price_id' => 'price_1SKjdpCdDYiPm1gGYh3L07ID',
            ],
            [
                'name' => 'Pro',
                'description' => 'For growing teams with advanced needs',
                'price' => 29.00,
                'interval' => 'month',
                'trial_days' => 7,
                'sort_order' => 2,
                'is_active' => true,
                'is_featured' => true,
                'stripe_product_id' => 'prod_THHtCcSB1Nzife', // Replace with actual Stripe IDs
                'stripe_price_id' => 'price_1SKjJTCdDYiPm1gGarSniU5z',
            ],
            [
                'name' => 'Business',
                'description' => 'Advanced features for established businesses',
                'price' => 79.00,
                'interval' => 'month',
                'trial_days' => 0,
                'sort_order' => 3,
                'is_active' => true,
                'is_featured' => false,
                'stripe_product_id' => 'prod_business_123',
                'stripe_price_id' => 'price_business_monthly_123',
            ],
            [
                'name' => 'Enterprise',
                'description' => 'Custom solutions for large organizations',
                'price' => 199.00,
                'interval' => 'month',
                'trial_days' => 0,
                'sort_order' => 4,
                'is_active' => true,
                'is_featured' => false,
                'stripe_product_id' => 'prod_enterprise_123',
                'stripe_price_id' => 'price_enterprise_monthly_123',
            ],
            // Yearly plans
            [
                'name' => 'Pro - Yearly',
                'description' => 'Save 20% with yearly billing',
                'price' => 279.00, // $29 * 12 * 0.8 = $279.20 (20% discount)
                'interval' => 'year',
                'trial_days' => 7,
                'sort_order' => 5,
                'is_active' => true,
                'is_featured' => false,
                'stripe_product_id' => 'prod_pro_yearly_123',
                'stripe_price_id' => 'price_pro_yearly_123',
            ],
            [
                'name' => 'Business - Yearly',
                'description' => 'Save 20% with yearly billing',
                'price' => 759.00, // $79 * 12 * 0.8 = $758.40
                'interval' => 'year',
                'trial_days' => 0,
                'sort_order' => 6,
                'is_active' => true,
                'is_featured' => false,
                'stripe_product_id' => 'prod_business_yearly_123',
                'stripe_price_id' => 'price_business_yearly_123',
            ],
        ];

        foreach ($plans as $planData) {
            Plan::create($planData);
        }

        $this->command->info('Plans seeded successfully!');
    }
}
