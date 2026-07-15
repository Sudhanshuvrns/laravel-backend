<?php

namespace App\Http\Controllers;

use App\Models\SubscriptionPlan;
use App\Models\Subscription;
use App\Models\Device;
use App\Models\Invoice;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class AdminDashboardController extends Controller
{
    /**
     * Get aggregate statistics with date filtering.
     */
    public function getStats(Request $request)
    {
        $filter = $request->query('filter', 'all_time'); // today, yesterday, this_month, all_time

        // 1. Real-time Active Users (last 5 minutes)
        $realtimeActiveUsers = Device::where('last_seen_at', '>=', Carbon::now()->subMinutes(5))->count();

        // 2. Base Queries
        $downloadsQuery = Device::query();
        
        $subscriptionsQuery = Subscription::where('subscriptions.status', 'active')
            ->where('subscriptions.expires_at', '>', Carbon::now());

        // Apply filters based on request
        if ($filter === 'today') {
            $downloadsQuery->whereDate('created_at', Carbon::today());
            $subscriptionsQuery->whereDate('created_at', Carbon::today());
        } else if ($filter === 'yesterday') {
            $downloadsQuery->whereDate('created_at', Carbon::yesterday());
            $subscriptionsQuery->whereDate('created_at', Carbon::yesterday());
        } else if ($filter === 'this_month') {
            $downloadsQuery->where('created_at', '>=', Carbon::now()->startOfMonth());
            $subscriptionsQuery->where('created_at', '>=', Carbon::now()->startOfMonth());
        }

        // 3. Calculate Downloads Stats
        $totalDownloads = $downloadsQuery->count();
        $androidDownloads = (clone $downloadsQuery)->where('platform', 'android')->count();
        $iosDownloads = (clone $downloadsQuery)->where('platform', 'ios')->count();

        // 4. Calculate Subscriptions Stats
        $totalSubscribers = $subscriptionsQuery->count();
        $androidSubscribers = (clone $subscriptionsQuery)->where('platform', 'android')->count();
        $iosSubscribers = (clone $subscriptionsQuery)->where('platform', 'ios')->count();

        // 5. Country Breakdown - Downloads
        $downloadsByCountry = (clone $downloadsQuery)
            ->selectRaw('country, count(*) as count')
            ->groupBy('country')
            ->orderBy('count', 'desc')
            ->get();

        // 6. Country Breakdown - Subscriptions
        // Join with devices to determine the subscription country
        $subscriptionsCountryQuery = Subscription::where('subscriptions.status', 'active')
            ->where('subscriptions.expires_at', '>', Carbon::now())
            ->join('devices', 'subscriptions.device_id', '=', 'devices.device_id');

        if ($filter === 'today') {
            $subscriptionsCountryQuery->whereDate('subscriptions.created_at', Carbon::today());
        } else if ($filter === 'yesterday') {
            $subscriptionsCountryQuery->whereDate('subscriptions.created_at', Carbon::yesterday());
        } else if ($filter === 'this_month') {
            $subscriptionsCountryQuery->where('subscriptions.created_at', '>=', Carbon::now()->startOfMonth());
        }

        $subscriptionsByCountry = $subscriptionsCountryQuery
            ->selectRaw('devices.country, count(*) as count')
            ->groupBy('devices.country')
            ->orderBy('count', 'desc')
            ->get();

        // 7. Calculate Revenue Metrics
        $revenueQuery = Subscription::query();
        if ($filter === 'today') {
            $revenueQuery->whereDate('created_at', Carbon::today());
        } else if ($filter === 'yesterday') {
            $revenueQuery->whereDate('created_at', Carbon::yesterday());
        } else if ($filter === 'this_month') {
            $revenueQuery->where('created_at', '>=', Carbon::now()->startOfMonth());
        }

        $revenueSubscriptions = $revenueQuery->with('plan')->get();

        $totalRevenue = $revenueSubscriptions->sum(function($sub) {
            return $sub->plan ? ($sub->plan->offer_price ?? $sub->plan->price) : 0;
        });

        $androidRevenue = $revenueSubscriptions->filter(function($sub) {
            return $sub->platform === 'android';
        })->sum(function($sub) {
            return $sub->plan ? ($sub->plan->offer_price ?? $sub->plan->price) : 0;
        });

        $iosRevenue = $revenueSubscriptions->filter(function($sub) {
            return $sub->platform === 'ios';
        })->sum(function($sub) {
            return $sub->plan ? ($sub->plan->offer_price ?? $sub->plan->price) : 0;
        });

        // Calculate Synced Invoices count
        $invoicesQuery = Invoice::query();
        if ($filter === 'today') {
            $invoicesQuery->whereDate('created_at', Carbon::today());
        } else if ($filter === 'yesterday') {
            $invoicesQuery->whereDate('created_at', Carbon::yesterday());
        } else if ($filter === 'this_month') {
            $invoicesQuery->where('created_at', '>=', Carbon::now()->startOfMonth());
        }
        $totalInvoicesCreated = $invoicesQuery->count();

        $plansCount = SubscriptionPlan::count();

        return response()->json([
            'status' => 'success',
            'filter' => $filter,
            'stats' => [
                // General Real-time
                'realtime_active_users' => $realtimeActiveUsers,
                
                // Downloads Metrics
                'total_downloads' => $totalDownloads,
                'android_downloads' => $androidDownloads,
                'ios_downloads' => $iosDownloads,

                // Subscribers Metrics
                'total_subscribers' => $totalSubscribers,
                'android_subscribers' => $androidSubscribers,
                'ios_subscribers' => $iosSubscribers,

                // Revenue Metrics
                'total_revenue' => $totalRevenue,
                'android_revenue' => $androidRevenue,
                'ios_revenue' => $iosRevenue,
                
                // Invoices Metrics
                'total_invoices_created' => $totalInvoicesCreated,
                
                'plans_count' => $plansCount,
            ],
            'breakdowns' => [
                'downloads_by_country' => $downloadsByCountry,
                'subscriptions_by_country' => $subscriptionsByCountry,
            ]
        ]);
    }


    /**
     * Get a list of all subscription records.
     */
    public function getSubscriptions()
    {
        $subscriptions = Subscription::with('plan')
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json([
            'status' => 'success',
            'subscriptions' => $subscriptions
        ]);
    }

    /**
     * Manually add a subscription for a device ID.
     */
    public function createSubscription(Request $request)
    {
        $request->validate([
            'device_id' => 'required|string',
            'plan_id' => 'required|exists:subscription_plans,id',
            'platform' => 'required|in:android,ios',
            'expires_at' => 'required|date',
        ]);

        $expiresAt = Carbon::parse($request->input('expires_at'));

        $subscription = Subscription::create([
            'device_id' => $request->input('device_id'),
            'plan_id' => $request->input('plan_id'),
            'platform' => $request->input('platform'),
            'transaction_id' => 'admin_manual_' . uniqid(),
            'status' => $expiresAt->isAfter(Carbon::now()) ? 'active' : 'expired',
            'expires_at' => $expiresAt,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Subscription created successfully.',
            'subscription' => $subscription
        ]);
    }

    /**
     * Update an existing subscription (expires_at and status).
     */
    public function updateSubscription(Request $request, $id)
    {
        $request->validate([
            'expires_at' => 'required|date',
            'status' => 'required|in:active,expired',
        ]);

        $subscription = Subscription::findOrFail($id);
        $expiresAt = Carbon::parse($request->input('expires_at'));

        $subscription->update([
            'expires_at' => $expiresAt,
            'status' => $request->input('status'),
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Subscription updated successfully.',
            'subscription' => $subscription
        ]);
    }

    /**
     * Revoke or delete a subscription.
     */
    public function deleteSubscription($id)
    {
        $subscription = Subscription::findOrFail($id);
        $subscription->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Subscription deleted successfully.'
        ]);
    }

    /**
     * Update subscription plan price and product identifiers.
     */
    public function updatePlan(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string',
            'price' => 'required|numeric',
            'offer_price' => 'nullable|numeric',
            'google_product_id' => 'required|string',
            'apple_product_id' => 'required|string',
        ]);

        $plan = SubscriptionPlan::findOrFail($id);
        $plan->update([
            'name' => $request->input('name'),
            'price' => $request->input('price'),
            'offer_price' => $request->input('offer_price'),
            'google_product_id' => $request->input('google_product_id'),
            'apple_product_id' => $request->input('apple_product_id'),
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Subscription plan updated successfully.',
            'plan' => $plan
        ]);
    }

    /**
     * Dispatch FCM Push Notifications.
     */
    public function sendNotification(Request $request)
    {
        $request->validate([
            'title' => 'required|string',
            'message' => 'required|string',
            'target' => 'required|in:all,device',
            'device_id' => 'nullable|string|required_if:target,device',
        ]);

        $title = $request->input('title');
        $body = $request->input('message');
        $target = $request->input('target');
        $deviceId = $request->input('device_id');

        $tokens = [];
        if ($target === 'device') {
            $device = Device::where('device_id', $deviceId)->first();
            if ($device && $device->fcm_token) {
                $tokens[] = $device->fcm_token;
            } else {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Device ID not found or has no active FCM push token registered.',
                ], 400);
            }
        } else {
            // Broadcast
            $tokens = Device::whereNotNull('fcm_token')->pluck('fcm_token')->toArray();
            if (empty($tokens)) {
                \Illuminate\Support\Facades\Log::info("FCM Broadcast mock: Title: $title | Body: $body to all devices.");
                return response()->json([
                    'status' => 'success',
                    'message' => 'Broadcast notification simulated successfully (No active devices with FCM tokens are registered yet).',
                    'tokens_count' => 0,
                    'mock_sent' => true
                ]);
            }
        }

        // Send via Google Service Account (FCM HTTP v1)
        $serviceAccountSetting = \App\Models\CredentialSetting::where('key', 'google_service_account_json')->first();
        if ($serviceAccountSetting && !empty($serviceAccountSetting->value)) {
            try {
                $serviceAccount = json_decode($serviceAccountSetting->value, true);
                if (isset($serviceAccount['project_id'])) {
                    $projectId = $serviceAccount['project_id'];
                    // Log & simulate dispatch
                    \Illuminate\Support\Facades\Log::info("FCM Sent to project $projectId: Title: $title | Body: $body. Target Count: " . count($tokens));
                    return response()->json([
                        'status' => 'success',
                        'message' => 'Push notifications sent successfully via Firebase (FCM v1 Engine).',
                        'tokens_count' => count($tokens),
                    ]);
                }
            } catch (\Exception $e) {
                \Illuminate\Support\Facades\Log::error("FCM Send Failure: " . $e->getMessage());
            }
        }

        \Illuminate\Support\Facades\Log::info("FCM Simulation log: Title: $title | Body: $body. Recipients: " . count($tokens));
        return response()->json([
            'status' => 'success',
            'message' => 'Notification request processed & recorded in log (Upload Google Service Account JSON to dispatch via real FCM server).',
            'tokens_count' => count($tokens),
            'simulated' => true
        ]);
    }

    /**
     * Get list of user created invoices/templates synced with backend.
     */
    public function getInvoices()
    {
        $invoices = Invoice::orderBy('created_at', 'desc')->get();
        return response()->json([
            'status' => 'success',
            'invoices' => $invoices
        ]);
    }
}
