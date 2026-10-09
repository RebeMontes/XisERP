<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\ServiceOrder;
use App\Models\User;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('service_visits', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(ServiceOrder::class)->constrained();
            $table->foreignIdFor(User::class, 'technician_id')->constrained();
            $table->string('service_location', 255);
            $table->string('site_contact_name', 150)->nullable();
            $table->dateTime('arrival_at')->index();
            $table->dateTime('departure_at')->nullable()->index();
            $table->text('serviced_equipment')->nullable();
            $table->text('network_points')->nullable();
            $table->text('network_configuration')->nullable();
            $table->text('network_tests')->nullable();
            $table->string('software_version', 100)->nullable();
            $table->string('license_provided_by', 100)->nullable();
            $table->text('software_configuration')->nullable();
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
