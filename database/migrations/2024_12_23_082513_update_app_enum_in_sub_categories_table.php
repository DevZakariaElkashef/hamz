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
        Schema::table('sub_categories', function (Blueprint $table) {
            // Drop the existing 'app' column and recreate it with the new values in the enum.
            $table->enum('app', ['mall', 'booth', 'coupons', 'earn', 'resale', 'rfoof', 'all', 'usedMarket'])
                ->change();
        });


    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sub_categories', function (Blueprint $table) {
            // Drop the updated 'app' column and recreate it without 'usedMarket'
            $table->enum('app', ['mall', 'booth', 'coupons', 'earn', 'resale', 'rfoof', 'all'])
                ->change();
        });
    }
};
