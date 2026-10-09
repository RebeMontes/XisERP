<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\ServiceOrder;
use App\Models\CustomerAsset;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('service_order_assets', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(ServiceOrder::class)->constrained();
            $table->foreignIdFor(CustomerAsset::class)->constrained();
            $table->text('reported_problem')->nullable();
            $table->text('requested_service')->nullable();
            $table->text('physical_condition')->nullable();
            $table->json('accessories')->nullable();
            $table->text('reception_notes')->nullable();
            $table->dateTime('received_at')->index();
            $table->string('status')->default('received')->index();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('service_order_assets');
    }
};
