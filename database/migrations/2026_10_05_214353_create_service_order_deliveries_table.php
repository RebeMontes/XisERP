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
        Schema::create('service_order_deliveries', function (Blueprint $table) {
            $table->id();
            $table->string('service_order_id');
            $table->string('result');
            $table->string('final_tests')->nullable();
            $table->string('recommendations')->nullable();
            $table->string('warranty_days');
            $table->string('delivered_at');
            $table->string('customer_accepted');
            $table->string('technician_name');
            $table->string('customer_name');
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('service_order_deliveries');
    }
};
