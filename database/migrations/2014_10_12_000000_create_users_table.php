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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('email')->unique()->nullable();
            $table->string('mobile')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password')->nullable();
            $table->rememberToken();
            $table->enum('role', ['admin', 'user', 'doctor'])->default('user');
            $table->text('token')->nullable();
            $table->text('email_token')->nullable();
            $table->text('otp')->nullable();
            $table->text('device_type')->nullable();
            $table->text('device_id')->nullable();
            $table->text('fcm_id')->nullable();
            $table->enum('email_verify', ['true', 'false'])->default('false');
            $table->enum('status', ['true', 'false'])->default('true');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
