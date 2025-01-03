<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCouponsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coupons', function (Blueprint $table) {
            $table->id(); // Auto-increment ID
            $table->string('coupen_name'); // Name of the coupon
            $table->text('description'); // Description of the coupon
            $table->enum('type', ['discount', 'cashback']); // Type of the coupon (e.g., discount or cashback)
            $table->decimal('value', 10, 2); // Value of the coupon (decimal for amount/percentage)
            $table->date('ex_date'); // Expiration date of the coupon
            $table->enum('action', ['0', '1'])->default('0'); // Enum for action (active or inactive)
            $table->timestamp('c_date')->useCurrent(); // Creation timestamp
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
        Schema::dropIfExists('coupons');
    }
}
