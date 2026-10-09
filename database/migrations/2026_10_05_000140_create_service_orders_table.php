<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Customer;
use App\Models\ServiceOrder;
use App\Models\User;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('service_orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_number', 30)->unique();
            $table->foreignIdFor(Customer::class)->constrained();
            $table->foreignIdFor(User::class, 'technician_id')->constrained();
            $table->string('service_type', 30)->index();
            $table->string('priority', 20)->default('normal')->index();
            $table->string('status', 30)->default('received')->index();
            $table->dateTime('received_at')->index();
            $table->dateTime('promised_at')->nullable()->index();
            $table->decimal('subtotal', 14, 2)->default(0.00);
            $table->decimal('tax_amount', 14, 2)->default(0.00);
            $table->decimal('total', 14, 2)->default(0.00);
            $table->decimal('amount_paid', 14, 2)->default(0.00);
            $table->decimal('balance_due', 14, 2)->default(0.00);
            $table->smallInteger('warranty_days')->unsigned();
            $table->foreignIdFor(User::class, 'created_by')->constrained();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('service_orders');
    }
};
