<?php

namespace Database\Seeders;

use App\Models\Plan;
use App\Models\PlanFeature;
use Illuminate\Database\Seeder;

class PlanFeatureSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $plans = Plan::all();

        $features = [
            // Starter Plan Features
            [
                'plan_name' => 'Starter',
                'features' => [
                    ['name' => 'Users', 'value' => '3', 'sort_order' => 1],
                    ['name' => 'Projects', 'value' => '5', 'sort_order' => 2],
                    ['name' => 'Tasks', 'value' => '100', 'sort_order' => 3],
                    ['name' => 'Products', 'value' => '10', 'sort_order' => 4],
                    ['name' => 'Categories', 'value' => '5', 'sort_order' => 5],
                    ['name' => 'Storage', 'value' => '1GB', 'sort_order' => 6],
                    ['name' => 'API Access', 'value' => 'false', 'sort_order' => 7],
                    ['name' => 'Priority Support', 'value' => 'false', 'sort_order' => 8],
                    ['name' => 'Custom Domain', 'value' => 'false', 'sort_order' => 9],
                    ['name' => 'Advanced Analytics', 'value' => 'false', 'sort_order' => 10],
                ],
            ],

            // Pro Plan Features
            [
                'plan_name' => 'Pro',
                'features' => [
                    ['name' => 'Users', 'value' => '10', 'sort_order' => 1],
                    ['name' => 'Projects', 'value' => '50', 'sort_order' => 2],
                    ['name' => 'Tasks', 'value' => '1000', 'sort_order' => 3],
                    ['name' => 'Products', 'value' => '100', 'sort_order' => 4],
                    ['name' => 'Categories', 'value' => '20', 'sort_order' => 5],
                    ['name' => 'Storage', 'value' => '10GB', 'sort_order' => 6],
                    ['name' => 'API Access', 'value' => 'true', 'sort_order' => 7],
                    ['name' => 'Priority Support', 'value' => 'true', 'sort_order' => 8],
                    ['name' => 'Custom Domain', 'value' => 'true', 'sort_order' => 9],
                    ['name' => 'Advanced Analytics', 'value' => 'true', 'sort_order' => 10],
                    ['name' => 'Custom Branding', 'value' => 'false', 'sort_order' => 11],
                    ['name' => 'SSO Integration', 'value' => 'false', 'sort_order' => 12],
                ],
            ],

            // Business Plan Features
            [
                'plan_name' => 'Business',
                'features' => [
                    ['name' => 'Users', 'value' => '50', 'sort_order' => 1],
                    ['name' => 'Projects', 'value' => 'Unlimited', 'sort_order' => 2],
                    ['name' => 'Tasks', 'value' => 'Unlimited', 'sort_order' => 3],
                    ['name' => 'Products', 'value' => '1000', 'sort_order' => 4],
                    ['name' => 'Categories', 'value' => '100', 'sort_order' => 5],
                    ['name' => 'Storage', 'value' => '100GB', 'sort_order' => 6],
                    ['name' => 'API Access', 'value' => 'true', 'sort_order' => 7],
                    ['name' => 'Priority Support', 'value' => 'true', 'sort_order' => 8],
                    ['name' => 'Custom Domain', 'value' => 'true', 'sort_order' => 9],
                    ['name' => 'Advanced Analytics', 'value' => 'true', 'sort_order' => 10],
                    ['name' => 'Custom Branding', 'value' => 'true', 'sort_order' => 11],
                    ['name' => 'SSO Integration', 'value' => 'true', 'sort_order' => 12],
                    ['name' => 'Dedicated Account Manager', 'value' => 'true', 'sort_order' => 13],
                    ['name' => 'Custom Workflows', 'value' => 'true', 'sort_order' => 14],
                ],
            ],

            // Enterprise Plan Features
            [
                'plan_name' => 'Enterprise',
                'features' => [
                    ['name' => 'Users', 'value' => 'Unlimited', 'sort_order' => 1],
                    ['name' => 'Projects', 'value' => 'Unlimited', 'sort_order' => 2],
                    ['name' => 'Tasks', 'value' => 'Unlimited', 'sort_order' => 3],
                    ['name' => 'Products', 'value' => 'Unlimited', 'sort_order' => 4],
                    ['name' => 'Categories', 'value' => 'Unlimited', 'sort_order' => 5],
                    ['name' => 'Storage', 'value' => '1TB', 'sort_order' => 6],
                    ['name' => 'API Access', 'value' => 'true', 'sort_order' => 7],
                    ['name' => 'Priority Support', 'value' => 'true', 'sort_order' => 8],
                    ['name' => 'Custom Domain', 'value' => 'true', 'sort_order' => 9],
                    ['name' => 'Advanced Analytics', 'value' => 'true', 'sort_order' => 10],
                    ['name' => 'Custom Branding', 'value' => 'true', 'sort_order' => 11],
                    ['name' => 'SSO Integration', 'value' => 'true', 'sort_order' => 12],
                    ['name' => 'Dedicated Account Manager', 'value' => 'true', 'sort_order' => 13],
                    ['name' => 'Custom Workflows', 'value' => 'true', 'sort_order' => 14],
                    ['name' => 'On-premise Deployment', 'value' => 'true', 'sort_order' => 15],
                    ['name' => 'Custom SLA', 'value' => 'true', 'sort_order' => 16],
                    ['name' => 'Training Sessions', 'value' => 'true', 'sort_order' => 17],
                ],
            ],

            // Yearly plans - same features as monthly counterparts
            [
                'plan_name' => 'Pro - Yearly',
                'features' => [
                    ['name' => 'Users', 'value' => '10', 'sort_order' => 1],
                    ['name' => 'Projects', 'value' => '50', 'sort_order' => 2],
                    ['name' => 'Tasks', 'value' => '1000', 'sort_order' => 3],
                    ['name' => 'Products', 'value' => '100', 'sort_order' => 4],
                    ['name' => 'Categories', 'value' => '20', 'sort_order' => 5],
                    ['name' => 'Storage', 'value' => '10GB', 'sort_order' => 6],
                    ['name' => 'API Access', 'value' => 'true', 'sort_order' => 7],
                    ['name' => 'Priority Support', 'value' => 'true', 'sort_order' => 8],
                    ['name' => 'Custom Domain', 'value' => 'true', 'sort_order' => 9],
                    ['name' => 'Advanced Analytics', 'value' => 'true', 'sort_order' => 10],
                    ['name' => 'Custom Branding', 'value' => 'false', 'sort_order' => 11],
                    ['name' => 'SSO Integration', 'value' => 'false', 'sort_order' => 12],
                    ['name' => 'Yearly Savings', 'value' => '20%', 'sort_order' => 13],
                ],
            ],

            [
                'plan_name' => 'Business - Yearly',
                'features' => [
                    ['name' => 'Users', 'value' => '50', 'sort_order' => 1],
                    ['name' => 'Projects', 'value' => 'Unlimited', 'sort_order' => 2],
                    ['name' => 'Tasks', 'value' => 'Unlimited', 'sort_order' => 3],
                    ['name' => 'Products', 'value' => '1000', 'sort_order' => 4],
                    ['name' => 'Categories', 'value' => '100', 'sort_order' => 5],
                    ['name' => 'Storage', 'value' => '100GB', 'sort_order' => 6],
                    ['name' => 'API Access', 'value' => 'true', 'sort_order' => 7],
                    ['name' => 'Priority Support', 'value' => 'true', 'sort_order' => 8],
                    ['name' => 'Custom Domain', 'value' => 'true', 'sort_order' => 9],
                    ['name' => 'Advanced Analytics', 'value' => 'true', 'sort_order' => 10],
                    ['name' => 'Custom Branding', 'value' => 'true', 'sort_order' => 11],
                    ['name' => 'SSO Integration', 'value' => 'true', 'sort_order' => 12],
                    ['name' => 'Dedicated Account Manager', 'value' => 'true', 'sort_order' => 13],
                    ['name' => 'Custom Workflows', 'value' => 'true', 'sort_order' => 14],
                    ['name' => 'Yearly Savings', 'value' => '20%', 'sort_order' => 15],
                ],
            ],
        ];

        foreach ($features as $planFeatures) {
            $plan = $plans->firstWhere('name', $planFeatures['plan_name']);

            if ($plan) {
                foreach ($planFeatures['features'] as $feature) {
                    PlanFeature::create([
                        'plan_id' => $plan->id,
                        'name' => $feature['name'],
                        'value' => $feature['value'],
                        'sort_order' => $feature['sort_order'],
                    ]);
                }
            }
        }

        $this->command->info('Plan features seeded successfully!');
    }
}
