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
        Schema::create('audit_logs', function (Blueprint $table) {
            $table->id();
            #$table->string('user_id');
            $table->string('action', 100)->index();
            $table->string('entity_type', 100)->index();
            $table->unsignedBigInteger('entity_id')->index();
            $table->json('details')->nullable();
            $table->string('ip_address', 45)->nullable()->index();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('audit_logs');
    }
};
