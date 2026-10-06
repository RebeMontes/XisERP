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
        Schema::create('service_order_backups', function (Blueprint $table) {
            $table->id();
            $table->string('service_order_id');
            $table->string('is_requested');
            $table->string('was_succesful');
            $table->string('content_types')->nullable();
            $table->string('delivery_method')->nullable();
            $table->string('result_location')->nullable();
            $table->string('failure_reason')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('service_order_backups');
    }
};
