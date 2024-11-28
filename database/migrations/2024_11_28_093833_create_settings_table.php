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
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('name_ar')->nullable();
            $table->string('name_en')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->tinyInteger('site_status')->nullable();
            $table->text('closed_message_ar')->nullable();
            $table->string('logo')->nullable();
            $table->text('firebase')->nullable();
            $table->tinyInteger('mentanceMode')->nullable();
            $table->text('mentanceMessage')->nullable();
            $table->string('verision')->nullable();
            $table->string('andriod')->nullable();
            $table->string('ios')->nullable();

            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
