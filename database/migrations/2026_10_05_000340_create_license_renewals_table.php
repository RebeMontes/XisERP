<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\License;
use App\Models\ServiceOrder;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('license_renewals', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(License::class)->constrained();
            $table->foreignIdFor(ServiceOrder::class)->constrained();
            $table->dateTime('previous_expiration_date')->nullable();
            $table->dateTime('new_activation_date')->nullable();
            $table->dateTime('new_expiration_date')->index();
            $table->decimal('renewal_cost', 14, 2)->default(0.00);
            $table->text('new_encrypted_license_key')->nullable();
            $table->char('new_license_key_last_five', 5)->nullable();
            $table->dateTime('renewed_at')->nullable()->index();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('license_renewals');
    }
};
