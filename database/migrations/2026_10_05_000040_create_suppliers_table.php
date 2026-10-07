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
        Schema::create('suppliers', function (Blueprint $table) {
            $table->id();
            $table->string('tax_id', 13)->nullable()->index();
            $table->string('legal_name', 200)->index();
            $table->string('trade_name', 150)->nullable()->index();
            $table->string('contact_name', 150)->nullable();
            $table->string('phone', 20)->nullable()->index();
            $table->string('whatsapp', 20)->nullable();
            $table->string('email', 254)->nullable()->index();
            $table->text('address')->nullable();
            $table->string('payment_terms', 100)->nullable();
            $table->text('notes')->nullable();
            $table->tinyInteger('is_active')->default(1)->index();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('suppliers');
    }
};
