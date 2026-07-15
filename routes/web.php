<?php

use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\AdminCredentialController;
use App\Http\Controllers\AdminDashboardController;
use Illuminate\Support\Facades\Route;

// Redirect root to admin dashboard
Route::get('/', function () {
    return redirect('/admin');
});

// Admin Dashboard View
Route::get('/admin', function () {
    return view('admin');
});

// Subscription Endpoints
Route::get('/api/subscription/plans', [SubscriptionController::class, 'getPlans']);
Route::get('/api/subscription/status/{device_id}', [SubscriptionController::class, 'checkStatus']);
Route::post('/api/subscription/verify', [SubscriptionController::class, 'verifyReceipt']);
Route::post('/api/subscription/register-token', [SubscriptionController::class, 'registerToken']);
Route::post('/api/invoices/sync', [SubscriptionController::class, 'syncInvoice']);

// Admin Configuration Endpoints
Route::post('/api/admin/settings', [AdminCredentialController::class, 'updateCredentials']);
Route::get('/api/admin/settings', [AdminCredentialController::class, 'getCredentials']);

// Admin Dashboard API Endpoints
Route::get('/api/admin/stats', [AdminDashboardController::class, 'getStats']);
Route::get('/api/admin/subscriptions', [AdminDashboardController::class, 'getSubscriptions']);
Route::post('/api/admin/subscriptions', [AdminDashboardController::class, 'createSubscription']);
// Note: We use match or put/delete as standard
Route::put('/api/admin/subscriptions/{id}', [AdminDashboardController::class, 'updateSubscription']);
Route::delete('/api/admin/subscriptions/{id}', [AdminDashboardController::class, 'deleteSubscription']);
Route::put('/api/admin/plans/{id}', [AdminDashboardController::class, 'updatePlan']);
Route::post('/api/admin/send-notification', [AdminDashboardController::class, 'sendNotification']);
Route::get('/api/admin/invoices', [AdminDashboardController::class, 'getInvoices']);



