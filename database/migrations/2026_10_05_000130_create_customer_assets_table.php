<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Customer;
use App\Models\Product;
use App\Models\Category;
use App\Models\Subcategory;
use App\Models\Brand;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('customer_assets', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Customer::class)->constrained();
            $table->foreignIdFor(Product::class)->constrained();
            $table->foreignIdFor(Category::class)->constrained();
            $table->foreignIdFor(Subcategory::class)->constrained();
            $table->string('asset_type', 30)->index();
            $table->string('name', 150)->index();
            $table->foreignIdFor(Brand::class)->constrained();
            $table->string('model', 100)->nullable()->index();
            $table->string('serial_number', 100)->nullable()->index();
            $table->string('imei', 20)->nullable()->index();
            $table->string('internal_code', 50)->nullable()->unique();
            $table->string('location', 150)->nullable();
            $table->dateTime('purchase_date')->nullable();
            $table->dateTime('installation_date')->nullable();
            $table->dateTime('service_start_date')->nullable();
            $table->dateTime('service_end_date')->nullable();
            $table->string('status', 30)->default('active')->index();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customer_assets');
    }
};
