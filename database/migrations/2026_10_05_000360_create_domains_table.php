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
        Schema::create('domains', function (Blueprint $table) {
            $table->id();
            $table->string('domain_name', 253)->unique();
            $table->string('registrar_name', 150)->nullable()->index();
            $table->string('hosting_provider', 150)->nullable()->index();
            $table->dateTime('registration_date')->nullable();
            $table->dateTime('expiration_date')->nullable()->index();
            $table->tinyInteger('auto_renewal')->default(0)->index();
            $table->string('status', 30)->default('active')->index();
            $table->json('name_servers')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('domains');
    }
};
