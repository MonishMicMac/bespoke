<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('super_save_deals', function (Blueprint $table) {
            $table->id();
            $table->string('super_save_deals_image');
            $table->string('super_save_deals_title');
            $table->string('super_save_deals_price');
            $table->string('super_save_deals_brand_name');
            $table->string('action');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('super_save_deals');
    }
};
