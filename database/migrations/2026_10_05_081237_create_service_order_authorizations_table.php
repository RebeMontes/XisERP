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
        Schema::create('service_order_authorizations', function (Blueprint $table) {
            $table->id();
            $table->string('service_order_id');
            $table->string('is_authorized');
            $table->string('authorization_method');
            $table->string('authorized_by_name')->nullable();
            $table->string('authorized_at')->nullable();
            $table->string('authorized_limit');
            $table->string('payment_method')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('service_order_authorizations');
    }
};
