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
        Schema::table('stores', function (Blueprint $table) {
            $table->tinyInteger('delivery_type')->after('app')->default(0)->comment('0 => dont have, 1 => has delivery');
            $table->boolean('pick_up')->after('app')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('stores', function (Blueprint $table) {
            $table->dropColumn('delivery_type');
            $table->dropColumn('pick_up');
        });
    }
};
