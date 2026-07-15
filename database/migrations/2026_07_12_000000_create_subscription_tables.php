<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('subscription_plans', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('type'); // weekly, yearly
            $table->decimal('price', 8, 2);
            $table->decimal('offer_price', 8, 2)->nullable();
            $table->integer('offer_duration_seconds')->default(86400); // 24 hours default
            $table->string('google_product_id')->nullable();
            $table->string('apple_product_id')->nullable();
            $table->timestamps();
        });

        Schema::create('subscriptions', function (Blueprint $table) {
            $table->id();
            $table->string('device_id')->index();
            $table->foreignId('plan_id')->constrained('subscription_plans')->onDelete('cascade');
            $table->string('platform'); // android, ios
            $table->string('transaction_id')->nullable();
            $table->string('status')->default('active'); // active, expired, cancelled
            $table->dateTime('expires_at');
            $table->timestamps();
        });

        Schema::create('credential_settings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->text('value')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('credential_settings');
        Schema::dropIfExists('subscriptions');
        Schema::dropIfExists('subscription_plans');
    }
};
