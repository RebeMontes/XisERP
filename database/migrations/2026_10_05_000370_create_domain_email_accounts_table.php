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
        Schema::create('domain_email_accounts', function (Blueprint $table) {
            $table->id();
            #$table->string('domain_id');
            $table->string('display_name', 150);
            $table->string('account_name', 64);
            $table->text('encrypted_password');
            $table->string('recovery_email', 254)->nullable();
            $table->unsignedInteger('storage_quota_mb')->default(0);
            $table->string('status', 30)->default('active');
            $table->text('notes')->nullable();
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
