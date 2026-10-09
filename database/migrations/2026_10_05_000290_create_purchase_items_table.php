<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Purchase;
use App\Models\Product;
use App\Models\ServiceOrderItem;
use App\Models\ServiceOrderAsset;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('purchase_items', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Purchase::class)->constrained();
            $table->foreignIdFor(Product::class)->constrained();
            $table->foreignIdFor(ServiceOrderItem::class)->constrained();
            $table->foreignIdFor(ServiceOrderAsset::class)->constrained();
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
