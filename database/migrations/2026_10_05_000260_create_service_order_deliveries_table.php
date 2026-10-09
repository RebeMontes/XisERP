<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\ServiceOrder;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('service_order_deliveries', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(ServiceOrder::class)->constrained();
            $table->string('result', 30)->index();
            $table->text('final_tests_summary')->nullable();
            $table->text('recommendations')->nullable();
            $table->unsignedSmallInteger('warranty_days')->default(0);
            $table->dateTime('delivered_at')->index();
            $table->tinyInteger('customer_accepted')->default(0);
            $table->string('technician_name', 150);
            $table->string('customer_name', 150);
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('service_order_deliveries');
    }
};
