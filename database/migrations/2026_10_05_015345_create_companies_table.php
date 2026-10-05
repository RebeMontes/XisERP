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
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->string('tax_id', 13)->nullable();
            $table->string('tax_regime', 120)->nullable();
            $table->string('legal_name', 180);
            $table->string('trade_name', 100);
            $table->string('commercial_name', 100)->nullable();
            $table->string('personal_id', 18)->nullable();
            $table->string('street', 150)->nullable();
            $table->string('exterior_num', 20)->nullable();
            $table->string('interior_num', 20)->nullable();
            $table->string('neighborhood', 120)->nullable();
            $table->string('city', 120)->nullable();
            $table->string('municipality', 120)->nullable();
            $table->string('state', 120)->nullable();
            $table->string('country', 120);
            $table->string('postal_code', 10)->nullable();
            $table->text('address_references')->nullable();
            $table->string('phone', 30)->nullable();
            $table->string('phone_type', 30)->nullable();
            $table->string('email', 160)->nullable();
            $table->string('whatsapp', 30)->nullable();
            $table->text('notes')->nullable();
            $table->tinyInteger('is_active')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('companies');
    }
};
