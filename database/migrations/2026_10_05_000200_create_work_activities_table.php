<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\ServiceOrderAsset;
use App\Models\User;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('work_activities', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(ServiceOrderAsset::class)->constrained();
            $table->foreignIdFor(User::class, 'technician_id')->constrained();
            $table->string('activity_name', 150)->index();
            $table->text('planned_description')->nullable();
            $table->text('performed_description')->nullable();
            $table->string('status')->default('pending')->index();
            $table->string('started_at')->nullable()->index();
            $table->string('completed_at')->nullable()->index();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('work_activities');
    }
};
