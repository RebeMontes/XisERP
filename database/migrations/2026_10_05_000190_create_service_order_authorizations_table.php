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
            #$table->string('service_order_id');
            $table->string('status', 20)->default('pending')->index();
            $table->string('authorization_method', 30)->nullable();
            $table->string('authorized_by_name', 150)->nullable();
            $table->dateTime('authorized_at')->nullable();
            $table->decimal('authorized_limit', 14, 2)->nullable();
            $table->string('payment_method', 30)->nullable();
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
