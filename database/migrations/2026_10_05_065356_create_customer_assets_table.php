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
        Schema::create('customer_assets', function (Blueprint $table) {
            $table->id();
            $table->string('customer_id');
            $table->string('product_id')->nullable();
            $table->string('asset_type');
            $table->string('name');
            $table->string('brand')->nullable();
            $table->string('model')->nullable();
            $table->string('serial_number')->nullable();
            $table->string('imei')->nullable();
            $table->string('internal_code')->nullable();
            $table->string('location')->nullable();
            $table->string('purchase_date')->nullable();
            $table->string('installation_date')->nullable();
            $table->string('service_start_date')->nullable();
            $table->string('service_end_date')->nullable();
            $table->string('status');
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customer_assets');
    }
};
