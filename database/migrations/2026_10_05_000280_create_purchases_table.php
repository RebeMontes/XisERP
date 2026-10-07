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
            $table->string('purchase_number', 30)->unique();
            #$table->string('supplier_id');
            #$table->string('service_order_id')->nullable();
            $table->string('purchase_source', 30)->index();
            $table->string('supplier_order_number', 100)->nullable()->index();
            $table->string('status', 30)->default('pending')->index();
            $table->dateTime('purchase_date')->index();
            $table->dateTime('estimated_delivery_date')->nullable()->index();
            $table->dateTime('received_at')->nullable()->index();
            $table->char('currency_code', 3)->default('MXN')->index();
            $table->decimal('exchange_rate', 18, 6)->default(1.000000);
            $table->decimal('subtotal', 14, 2)->default(0.00);
            $table->decimal('tax_amount', 14, 2)->default(0.00);
            $table->decimal('shipping_cost', 14, 2)->default(0.00);
            $table->decimal('total', 14, 2)->default(0.00);
            $table->string('shipping_company')->nullable()->index();
            $table->string('tracking_number')->nullable()->index();
            $table->text('notes')->nullable();
            #$table->string('created_by');
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
