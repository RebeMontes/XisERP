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
            $table->string('code', 50)->unique();
            $table->char('sat_product_code', 8)->nullable()->index();
            #$table->string('sat_unit_code')->nullable();
            $table->string('product_type', 20)->index();
            #$table->string('unit_of_measure');
            $table->string('description', 255);
            #$table->string('brand')->nullable();
            $table->decimal('cost', 14, 2);
            $table->decimal('retail_price', 14, 2);
            $table->decimal('whosale_price', 14, 2)->nullable();
            #$table->string('additional_price')->nullable();
            #$table->string('taxes')->nullable();
            #$table->string('vat_rate');
            #$table->string('excise_tax_rate');
            $table->char('tax_object_code', 2)->nullable();
            $table->tinyInteger('track_inventory', 1)->default(0)->index();
            $table->decimal('stock_quantity', 14, 3)->default(0.000);
            $table->decimal('minimum_stock', 14, 3)->default(0.000);
            $table->string('storage_location', 100)->nullable();
            $table->string('image_path', 500)->nullable();
            $table->string('is_active')->default(1)->index();
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
