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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('order_status_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('store_id')->nullable()->constrained()->onDelete('set null');
            $table->decimal('sub_total')->nullable();
            $table->decimal('tax')->nullable();
            $table->decimal('delivery')->nullable();
            $table->decimal('discount')->nullable();
            $table->decimal('total')->nullable();
            $table->foreignId('coupon_id')->nullable()->constrained()->onDelete('set null');
            $table->tinyInteger('payment_type')->nullable()->comment('0 => online, 1 => wallet');
            $table->tinyInteger('payment_status')->nullable()->comment('0 => pending, 1 => paid, 2 => faild');
            $table->tinyInteger('delivery_type')->nullable()->comment('1 => first_company, 2 => second_company, 3 => store delivery, 4 => pick up from store');
            $table->string('lat')->nullable();
            $table->string('lng')->nullable();
            $table->string('address')->nullable();
            $table->string('transaction_id')->nullable();
            $table->text('note')->nullable();
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
        Schema::dropIfExists('orders');
    }
};
