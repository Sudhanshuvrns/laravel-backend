<?php

namespace Database\Seeders;

use App\Models\SubscriptionPlan;
use App\Models\Subscription;
use App\Models\Device;
use App\Models\Invoice;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Seed Weekly Subscription Plan
        $weeklyPlan = SubscriptionPlan::updateOrCreate(
            ['google_product_id' => 'com.invoicetemplate.weekly_premium'],
            [
                'name' => 'Weekly Premium',
                'type' => 'weekly',
                'price' => 4.99,
                'offer_price' => 2.49,
                'offer_duration_seconds' => 86400,
                'apple_product_id' => 'com.invoicetemplate.weekly_premium',
            ]
        );

        // 2. Seed Yearly Subscription Plan
        $yearlyPlan = SubscriptionPlan::updateOrCreate(
            ['google_product_id' => 'com.invoicetemplate.yearly_premium'],
            [
                'name' => 'Yearly Premium',
                'type' => 'yearly',
                'price' => 49.99,
                'offer_price' => 29.99,
                'offer_duration_seconds' => 86400,
                'apple_product_id' => 'com.invoicetemplate.yearly_premium',
            ]
        );

        // Clear existing devices, subscriptions, and invoices to clean all mock data
        Subscription::truncate();
        Device::truncate();
        Invoice::truncate();
    }
}
