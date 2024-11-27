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
        Schema::table('products', function (Blueprint $table) {
            $table->foreignId('direction_id')->nullable()->constrained()->onDelete('cascade');
            $table->foreignId('product_status_id')->nullable()->constrained()->onDelete('cascade');
            $table->foreignId('country_id')->nullable()->constrained('countries')->onDelete('cascade');
            $table->foreignId('sub_category_id')->nullable()->constrained('sub_categories')->onDelete('cascade');
            $table->string('lat')->nullable();
            $table->string('long')->nullable();
            $table->text('address_ar')->nullable();
            $table->text('address_en')->nullable();
            $table->string('misahuh')->nullable();
            $table->string('count_rooms')->nullable();
            $table->string('number_bathrooms')->nullable();
            $table->string('count_floor')->nullable();
            $table->string('number_councils')->nullable();
            $table->string('number_halls')->nullable();
            $table->string('street_view')->nullable();
            $table->text('location')->nullable(); // Fixed typo
            $table->string('number_parties_seeking')->nullable();
            $table->string('width')->nullable();
            $table->string('height')->nullable();
            $table->string('floor_number')->nullable();
            $table->string('property_age')->nullable();
            $table->tinyInteger('status')->nullable();
            $table->tinyInteger('verify')->nullable();
            $table->string('neighborhood')->nullable();
            $table->string('apartments_number')->nullable();
            $table->string('license_number')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropForeign(['direction_id']);
            $table->dropColumn('direction_id');

            $table->dropForeign(['product_status_id']);
            $table->dropColumn('product_status_id');

            $table->dropForeign(['country_id']);
            $table->dropColumn('country_id');

            $table->dropColumn('lat');
            $table->dropColumn('long');
            $table->dropColumn('address_ar');
            $table->dropColumn('address_en');
            $table->dropColumn('misahuh');
            $table->dropColumn('count_rooms');
            $table->dropColumn('number_bathrooms');
            $table->dropColumn('count_floor');
            $table->dropColumn('number_councils');
            $table->dropColumn('number_halls');
            $table->dropColumn('street_view');
            $table->dropColumn('location'); // Fixed typo
            $table->dropColumn('number_parties_seeking');
            $table->dropColumn('width');
            $table->dropColumn('height');
            $table->dropColumn('floor_number');
            $table->dropColumn('property_age');
            $table->dropColumn('status');
            $table->dropColumn('verify');
            $table->dropColumn('neighborhood');
            $table->dropColumn('apartments_number');
            $table->dropColumn('license_number');
        });
    }
};
