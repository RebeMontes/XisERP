<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Domain;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('domain_email_accounts', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Domain::class)->constrained();
            $table->string('display_name', 150);
            $table->string('account_name', 64);
            $table->text('encrypted_password');
            $table->string('recovery_email', 254)->nullable();
            $table->unsignedInteger('storage_quota_mb')->default(0);
            $table->string('status', 30)->default('active');
            $table->text('notes')->nullable();
            $table->unique(['domain_id', 'account_name']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('domain_email_accounts');
    }
};
