<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Product;
use App\Models\ServiceOrder;
use App\Models\Purchase;
use App\Models\User;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('inventory_movements', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Product::class)->constrained();
            $table->string('movement_type', 30)->index();
            $table->decimal('quantity', 14, 3);
            $table->decimal('previous_stock', 14, 3);
            $table->decimal('new_stock', 14, 3);
            $table->foreignIdFor(ServiceOrder::class)->constrained();
            $table->foreignIdFor(Purchase::class)->constrained();
            $table->string('reference')->nullable()->index();
            $table->text('notes')->nullable();
            $table->foreignIdFor(User::class)->constrained();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventory_movements');
    }
};
