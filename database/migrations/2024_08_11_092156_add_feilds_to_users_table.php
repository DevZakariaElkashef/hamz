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
        Schema::table('users', function (Blueprint $table) {
            $table->string('phone')->nullable();
            $table->string('image')->nullable();
            $table->string('device_token')->nullable();
            $table->string('otp')->nullable();
            $table->boolean('is_active')->default(0);

            $table->index('otp');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('phone');
            $table->dropColumn('image');
            $table->dropColumn('device_token');
            $table->dropColumn('otp');
            $table->dropColumn('is_active');
        });
    }
};
