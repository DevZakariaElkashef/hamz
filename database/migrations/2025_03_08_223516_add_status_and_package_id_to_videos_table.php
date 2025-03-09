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
        Schema::table('videos', function (Blueprint $table) {
            $table->dropColumn('active_status');
            $table->dropForeign(['package_id']);
            $table->dropColumn('package_id');
        });
        Schema::table('videos', function (Blueprint $table) {
            $table->boolean('payment_status')->default(false); // Change default value if needed
            $table->unsignedBigInteger('package_id')->nullable();

            $table->foreign('package_id')->references('id')->on('packages')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('videos', function (Blueprint $table) {
            $table->dropColumn('payment_status');
            $table->dropForeign(['package_id']);
            $table->dropColumn('package_id');
        });
    }
};
