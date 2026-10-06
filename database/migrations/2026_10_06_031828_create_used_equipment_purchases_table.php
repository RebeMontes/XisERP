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
        Schema::create('used_equipment_purchases', function (Blueprint $table) {
            $table->id();
            $table->string('');
            $table->string('service_order_id');
            $table->string('seller_name');
            $table->string('presented_identification');
            $table->string('equipment_description');
            $table->string('serial_or_imei');
            $table->string('working_condition');
            $table->string('agreed_price');
            $table->string('declared_origin');
            $table->string('purchase_date');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('used_equipment_purchases');
    }
};
