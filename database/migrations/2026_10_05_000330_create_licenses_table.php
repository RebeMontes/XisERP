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
            #$table->string('customer_id');
            #$table->string('custormer_asset_id');
            #$table->string('product_id');
            #$table->string('service_order_id')->nullable();
            $table->string('license_type', 50)->nullable()->index();
            $table->string('product_name', 200);
            $table->string('version', 50)->nullable();
            $table->string('assigned_equipment', 200)->nullable();
            $table->string('equipment_serial_number', 100)->nullable()->index();
            $table->string('registration_email', 254)->nullable()->index();
            $table->string('subscription_number', 100)->nullable()->index();
            $table->text('encrypted_license_key')->nullable();
            $table->char('license_key_last_five', 5)->nullable();
            $table->string('management_portal_url', 2048)->nullable();
            $table->dateTime('purchase_date')->nullable()->index();
            $table->dateTime('activation_date')->nullable()->index();
            $table->dateTime('expiration_date')->nullable()->index();
            $table->unsignedSmallInteger('notification_days')->default(14);
            $table->tinyInteger('auto_renewal')->default(0)->index();
            $table->string('renewal_manager', 150)->nullable();
            $table->decimal('renewal_cost', 14, 2)->default(0.00);
            $table->string('status', 30)->default('pending')->index();
            $table->text('notes')->nullable();
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
