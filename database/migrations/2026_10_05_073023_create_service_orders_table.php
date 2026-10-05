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
        Schema::create('service_orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_number');
            $table->string('customer_id');
            $table->string('customer_asset_id')->nullable();
            $table->string('technician_id')->nullable();
            $table->string('service_type');
            $table->string('status');
            $table->string('received_at');
            $table->string('promised_at')->nullable();
            $table->string('equipment_type')->nullable();
            $table->string('brand')->nullable();
            $table->string('model')->nullable();
            $table->string('serial_number')->nullable();
            $table->string('imei')->nullable();
            $table->string('operating_system')->nullable();
            $table->string('accessories')->nullable();
            $table->string('physical_condition')->nullable();
            $table->string('reported_problem');
            $table->string('diagnosis')->nullable();
            $table->string('work_performed')->nullable();
            $table->string('recommendations')->nullable();
            $table->string('subtotal');
            $table->string('tax_amount');
            $table->string('total');
            $table->string('amount_paid');
            $table->string('balance_due');
            $table->string('warranty_days');
            $table->string('created_by');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('service_orders');
    }
};
