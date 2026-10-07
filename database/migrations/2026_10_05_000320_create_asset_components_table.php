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
        Schema::create('asset_components', function (Blueprint $table) {
            $table->id();
            $table->string('component_name', 150)->index();
            $table->string('serial_number', 100)->nullable()->index();
            $table->dateTime('installed_at')->index();
            $table->dateTime('removed_at')->nullable()->index();
            $table->dateTime('warranty_expires_at')->nullable()->index();
            $table->string('status', 20)->default('installed')->index();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('asset_components');
    }
};
