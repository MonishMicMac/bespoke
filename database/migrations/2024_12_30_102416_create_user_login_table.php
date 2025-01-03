<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserLoginTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_login', function (Blueprint $table) {
            $table->id(); // Auto-increment ID
            $table->string('username');
            $table->string('mobile')->unique();
            $table->string('email')->unique();
            $table->string('password'); // Hashed password
            $table->string('otp')->nullable();
            $table->text('address');
            $table->string('pincode');
            $table->timestamp('c_date')->useCurrent(); // Current timestamp for creation date
            $table->boolean('action')->default(true); // Action status (true for active)
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
        Schema::dropIfExists('user_login');
    }
}
