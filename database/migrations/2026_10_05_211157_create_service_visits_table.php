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
        Schema::create('service_visits', function (Blueprint $table) {
            $table->id();
            $table->string('service_order_id');
            $table->string('service_location');
            $table->string('site_contact_name')->nullable();
            $table->string('arrival_at');
            $table->string('departure_at')->nullable();
            $table->string('serviced_equipment')->nullable();
            $table->string('network_points')->nullable();
            $table->string('network_configuration')->nullable();
            $table->string('network_tests')->nullable();
            $table->string('software_version')->nullable();
            $table->string('license_provided_by')->nullable();
            $table->string('software_configuration')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('service_visits');
    }
};
