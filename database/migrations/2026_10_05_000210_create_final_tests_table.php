<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\ServiceOrderAsset;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('final_tests', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(ServiceOrderAsset::class)->constrained();
            $table->string('test_name', 120)->index();
            $table->text('result');
            $table->string('status', 30)->index();
            $table->text('notes')->nullable();
            $table->dateTime('performed_at');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('final_tests');
    }
};
