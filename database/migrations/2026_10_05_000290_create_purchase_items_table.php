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
        Schema::create('purchase_items', function (Blueprint $table) {
            $table->id();
            #$table->string('purchase_id');
            #$table->string('product_id');
            #$table->string('service_order_item_id')->nullable();
            $table->decimal('quantity', 12, 3);
            $table->decimal('unit_cost', 14, 2)->default(0.00);
            $table->decimal('discount_amount', 14, 2)->default(0.00);
            $table->decimal('tax_amount', 14, 2)->default(0.00);
            $table->decimal('line_total', 14, 2)->default(0.00);
            $table->decimal('received_quantity', 12, 3)->default(0.00);
            $table->tinyInteger('added_to_inventory')->default(0)->index();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchase_items');
    }
};
