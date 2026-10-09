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
        Schema::create('used_equipment_purchases', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(ServiceOrder::class)->constrained();
            $table->string('seller_name', 150)->index();
            $table->string('presented_identification', 100)->nullable();
            $table->text('equipment_description');
            $table->string('serial_or_imei', 100)->nullable()->index();
            $table->text('working_condition')->nullable();
            $table->decimal('agreed_price', 14, 2)->default(0.00);
            $table->text('declared_origin')->nullable();
            $table->dateTime('purchase_date')->index();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('used_equipment_purchases');
    }
};
