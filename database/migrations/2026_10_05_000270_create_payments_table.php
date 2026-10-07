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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            #$table->string('service_order_id');
            $table->dateTime('payment_date')->index();
            $table->decimal('amount', 14, 2)->default(0.00);
            $table->string('payment_method', 30)->index();
            $table->string('reference', 100)->nullable()->index();
            $table->text('notes')->nullable();
            #$table->string('received_by_user_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
