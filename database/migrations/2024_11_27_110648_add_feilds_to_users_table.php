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
            $table->string('code')->nullable();
            $table->string('val_license')->nullable();
            $table->tinyInteger('status')->nullable();
            $table->foreignId('advertisercharacter_id')->nullable()->constrained('advertiser_characters')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('code');
            $table->dropColumn('val_license');
            $table->dropColumn('status');
            $table->dropForeign(['advertisercharacter_id']);
            $table->dropColumn('advertisercharacter_id');
        });
    }
};
