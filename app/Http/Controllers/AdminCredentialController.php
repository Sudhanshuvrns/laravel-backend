<?php

namespace App\Http\Controllers;

use App\Models\CredentialSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class AdminCredentialController extends Controller
{
    /**
     * Store App Store / Play Store credentials keys & active offers details.
     */
    public function updateCredentials(Request $request)
    {
        $request->validate([
            'apple_shared_secret' => 'nullable|string',
            'google_service_account_json' => 'nullable|string',
            'active_offer_title' => 'nullable|string',
            'active_offer_discount' => 'nullable|integer|min:0|max:100',
            'active_offer_duration_hours' => 'nullable|integer|min:1',
        ]);

        if ($request->has('apple_shared_secret')) {
            CredentialSetting::updateOrCreate(
                ['key' => 'apple_shared_secret'],
                ['value' => $request->input('apple_shared_secret')]
            );
        }

        if ($request->has('google_service_account_json')) {
            CredentialSetting::updateOrCreate(
                ['key' => 'google_service_account_json'],
                ['value' => $request->input('google_service_account_json')]
            );
        }

        if ($request->has('active_offer_title')) {
            CredentialSetting::updateOrCreate(
                ['key' => 'active_offer_title'],
                ['value' => $request->input('active_offer_title')]
            );
        }

        if ($request->has('active_offer_discount')) {
            CredentialSetting::updateOrCreate(
                ['key' => 'active_offer_discount'],
                ['value' => $request->input('active_offer_discount')]
            );
        }

        if ($request->has('active_offer_duration_hours')) {
            $hours = (int) $request->input('active_offer_duration_hours');
            $endsAt = Carbon::now()->addHours($hours)->toIso8601String();
            CredentialSetting::updateOrCreate(
                ['key' => 'active_offer_ends_at'],
                ['value' => $endsAt]
            );
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Settings & special offer credentials updated successfully.'
        ]);
    }

    /**
     * Retrieve stored keys structure (masking contents for security).
     */
    public function getCredentials()
    {
        $appleSecret = CredentialSetting::where('key', 'apple_shared_secret')->first();
        $googleJson = CredentialSetting::where('key', 'google_service_account_json')->first();
        $offerTitle = CredentialSetting::where('key', 'active_offer_title')->first();
        $offerDiscount = CredentialSetting::where('key', 'active_offer_discount')->first();
        $offerEndsAt = CredentialSetting::where('key', 'active_offer_ends_at')->first();

        // Calculate hours remaining if set
        $hoursRemaining = null;
        if ($offerEndsAt && $offerEndsAt->value) {
            $ends = Carbon::parse($offerEndsAt->value);
            if ($ends->isFuture()) {
                $hoursRemaining = (int) Carbon::now()->diffInHours($ends, false);
                if ($hoursRemaining < 1) $hoursRemaining = 1; // round up
            }
        }

        return response()->json([
            'status' => 'success',
            'credentials' => [
                'apple_shared_secret' => $appleSecret && $appleSecret->value ? '********' . substr($appleSecret->value, -4) : null,
                'google_service_account_json_configured' => $googleJson && !empty($googleJson->value) ? true : false,
            ],
            'active_offer' => [
                'title' => $offerTitle ? $offerTitle->value : 'WELCOME SPECIAL OFFER',
                'discount' => $offerDiscount ? (int) $offerDiscount->value : 50,
                'duration_hours' => $hoursRemaining,
                'ends_at' => $offerEndsAt ? $offerEndsAt->value : null,
            ]
        ]);
    }
}
