<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\ServiceOrder;
use App\Models\ServiceOrderAsset;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('service_order_evidences', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(ServiceOrder::class)->constrained();
            $table->foreignIdFor(ServiceOrderAsset::class)->constrained();
            $table->string('stage', 30)->index();
            $table->string('file_path', 500);
            $table->string('mime_type', 100);
            $table->unsignedBigInteger('size_bytes')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('service_order_evidences');
    }
};
