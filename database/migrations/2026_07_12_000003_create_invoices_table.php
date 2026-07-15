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
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->string('device_id')->index();
            $table->string('invoice_id')->unique();
            $table->string('invoice_number');
            $table->string('client_name')->nullable();
            $table->decimal('total_amount', 12, 2)->default(0.00);
            $table->string('template_id')->default('minimal_white');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
