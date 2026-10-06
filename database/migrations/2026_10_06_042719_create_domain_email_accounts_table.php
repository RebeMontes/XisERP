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
            $table->string('domain_id');
            $table->string('display_name');
            $table->string('account_name');
            $table->string('encrypted_password');
            $table->string('recovery_email')->nullable();
            $table->string('storage_quota_mb');
            $table->string('status');
            $table->string('notes')->nullable();
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
