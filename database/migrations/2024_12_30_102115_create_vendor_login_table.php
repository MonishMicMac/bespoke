<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVendorLoginTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vendor_login', function (Blueprint $table) {
            $table->id(); // Auto-increment ID
            $table->string('shop_name');
            $table->string('username');
            $table->string('mobile_no');
            $table->string('email')->unique();
            $table->text('address');
            $table->string('pincode');
            $table->string('vendor_type');
            $table->string('gst_no')->nullable();
            $table->string('pan_no')->nullable();
            $table->boolean('approval_status')->default(false);
            $table->boolean('is_customization')->default(false);
            $table->timestamp('c_date')->useCurrent();
            $table->string('password');
            $table->string('otp')->nullable();
            $table->string('genders');
            $table->boolean('in_designer')->default(false);
            $table->text('description')->nullable();
            $table->timestamps(); // Adds created_at and updated_at
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vendor_login');
    }
}
