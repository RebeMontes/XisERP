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
        Schema::create('licenses', function (Blueprint $table) {
            $table->id();
            $table->string('customer_id');
            $table->string('custormer_asset_id');
            $table->string('product_id');
            $table->string('service_order_id')->nullable();
            $table->string('license_type')->nullable();
            $table->string('product_name');
            $table->string('version')->nullable();
            $table->string('assigned_equipment')->nullable();
            $table->string('equipment_serial_number')->nullable();
            $table->string('registration_email')->nullable();
            $table->string('subscription_number')->nullable();
            $table->string('encrypted_license_key')->nullable();
            $table->string('license_key_last_five')->nullable();
            $table->string('management_portal_url')->nullable();
            $table->string('purchase_date')->nullable();
            $table->string('activation_date');
            $table->string('expiration_date');
            $table->string('notification_days');
            $table->string('auto_renewal');
            $table->string('renewal_manager')->nullable();
            $table->string('renewal_cost');
            $table->string('status');
            $table->text('notes')->nullable()->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('licenses');
    }
};
