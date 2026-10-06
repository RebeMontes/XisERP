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
        Schema::create('purchases', function (Blueprint $table) {
            $table->id();
            $table->string('purchase_number');
            $table->string('supplier_id');
            $table->string('service_order_id')->nullable();
            $table->string('purchase_source');
            $table->string('supplier_order_number')->nullable();
            $table->string('status');
            $table->string('purchase_date');
            $table->string('estimated_delivery_date')->nullable();
            $table->string('received_at')->nullable();
            $table->string('currency_code');
            $table->string('exchange_rate');
            $table->string('subtotal');
            $table->string('tax_amount');
            $table->string('shipping_cost');
            $table->string('total');
            $table->string('shipping_company')->nullable();
            $table->string('tracking_number')->nullable();
            $table->text('notes')->nullable();
            $table->string('created_by');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchases');
    }
};
