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
        Schema::create('inventory_movements', function (Blueprint $table) {
            $table->id();
            #$table->string('product_id');
            $table->string('movement_type', 30)->index();
            $table->decimal('quantity', 14, 3);
            $table->decimal('previous_stock', 14, 3);
            $table->decimal('new_stock', 14, 3);
            $table->string('reference')->nullable()->index();
            $table->text('notes')->nullable();
            #$table->string('user_id');
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
