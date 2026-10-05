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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('code');
            $table->string('sat_product_code')->nullable();
            $table->string('sat_unit_code')->nullable();
            $table->string('product_type');
            $table->string('unit_of_measure');
            $table->string('description');
            $table->string('brand')->nullable();
            $table->string('cost');
            $table->string('retail_price');
            $table->string('whosale_price')->nullable();
            $table->string('additional_price')->nullable();
            $table->string('taxes')->nullable();
            $table->string('vat_rate');
            $table->string('excise_tax_rate');
            $table->string('tax_object_code')->nullable();
            $table->string('stock_quantity');
            $table->string('minimum_stock');
            $table->string('storage_location')->nullable();
            $table->string('image_path')->nullable();
            $table->string('is_active')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
