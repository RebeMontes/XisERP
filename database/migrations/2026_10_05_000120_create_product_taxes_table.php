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
        Schema::create('product_taxes', function (Blueprint $table) {
            $table->biginteger('product_id')->unsigned()->unique();
            $table->biginteger('tax_id')->unsigned()->unique();
            $table->primary(['product_id', 'tax_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_taxes');
    }
};
