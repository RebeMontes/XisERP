<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\ServiceOrder;
use App\Models\ServiceOrderAsset;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('service_order_backups', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(ServiceOrder::class)->constrained();
            $table->foreignIdFor(ServiceOrderAsset::class)->constrained();
            $table->tinyInteger('is_requested')->default(0);
            $table->tinyInteger('was_succesful')->nullable();
            $table->json('content_types')->nullable();
            $table->string('delivery_method', 50)->nullable();
            $table->string('result_location', 500)->nullable();
            $table->text('failure_reason')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('service_order_backups');
    }
};
