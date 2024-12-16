<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up()
    {
        DB::statement("ALTER TABLE `sliders` MODIFY `app` ENUM('mall', 'booth', 'coupons', 'earn', 'resale', 'rfoof', 'all', 'hamz')");
    }

    public function down()
    {
        DB::statement("ALTER TABLE `sliders` MODIFY `app` ENUM('mall', 'booth', 'coupons', 'earn', 'resale', 'rfoof', 'all')");
    }
};
