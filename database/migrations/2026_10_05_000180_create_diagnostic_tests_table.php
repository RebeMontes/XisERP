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
        Schema::create('diagnostic_tests', function (Blueprint $table) {
            $table->id();
            $table->string('test_name', 120)->index();
            $table->string('tool_used', 120)->nullable();
            $table->text('result');
            $table->string('status', 20)->nullable()->index();
            $table->text('notes')->nullable();
            $table->dateTime('performed_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('diagnostic_tests');
    }
};
