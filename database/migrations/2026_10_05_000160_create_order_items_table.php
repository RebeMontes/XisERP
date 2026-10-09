<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\ServiceOrder;
use App\Models\ServiceOrderAsset;
use App\Models\Product;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(ServiceOrder::class)->constrained();
            $table->foreignIdFor(ServiceOrderAsset::class)->constrained();
            $table->foreignIdFor(Product::class)->constrained();
            $table->string('product_code_snapshot', 50)->nullable();
            $table->string('description', 255);
            $table->decimal('quantity', 12, 3)->default(1.000);
            $table->decimal('unit_price', 14, 2)->default(0.00);
            $table->decimal('discount_amount', 14, 2)->default(0.00);
            $table->decimal('tax_amount', 14, 2)->default(0.00);
            $table->decimal('line_total', 14, 2)->default(0.00);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};
