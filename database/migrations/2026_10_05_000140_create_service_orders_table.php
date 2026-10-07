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
            $table->string('order_number', 30)->unique();
            #$table->string('customer_id'); bigint unsigned?
            #$table->string('technician_id'); bigint unsigned?
            $table->string('service_type', 30)->index();
            $table->string('priority', 20)->default('normal')->index();
            $table->string('status', 30)->default('received')->index();
            $table->dateTime('received_at')->index();
            $table->dateTime('promised_at')->nullable()->index();
            $table->decimal('subtotal', 14, 2)->default(0.00);
            $table->decimal('tax_amount', 14, 2)->default(0.00);
            $table->decimal('total', 14, 2)->default(0.00);
            $table->decimal('amount_paid', 14, 2)->default(0.00);
            $table->decimal('balance_due', 14, 2)->default(0.00);
            #$table->string('warranty_days'); SMALLINT UNSIGNED?
            #$table->string('created_by'); BIGINT UNSIGNED?
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
