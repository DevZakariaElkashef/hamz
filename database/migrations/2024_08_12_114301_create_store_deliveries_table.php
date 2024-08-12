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
        Schema::create('store_deliveries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('store_id')->nullable()->constrained()->onDelete('cascade');
            $table->decimal('fixed_value')->nullable();
            $table->string('free_delivery_distance')->default(0);
            $table->decimal('cost_per_km')->default(0);
            $table->string('max_distance')->nullable();
            $table->tinyInteger('default_type')->comment('0 => fixed value, 1 => dynamic distance');
            $table->enum('app', ['mall', 'booth', 'coupons', 'earn', 'resale', 'rfoof', 'all']);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('store_deliveries');
    }
};
