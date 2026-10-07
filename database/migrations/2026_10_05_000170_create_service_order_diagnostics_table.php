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
        Schema::create('service_order_diagnostics', function (Blueprint $table) {
            $table->id();
            $table->text('diagnosis_text');
            $table->string('result_code', 40)->index();
            $table->string('severity', 20)->nullable()->index();
            $table->string('cause_type', 20)->nullable();
            $table->text('cause_text')->nullable();
            $table->json('affected_components')->nullable();
            $table->text('recommended_solutions')->nullable();
            $table->text('risks_notes')->nullable();
            $table->dateTime('diagnosed_at')->nullable()->index();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('service_order_diagnostics');
    }
};
