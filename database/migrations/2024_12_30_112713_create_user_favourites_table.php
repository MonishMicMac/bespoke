<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserFavouritesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_favourites', function (Blueprint $table) {
            $table->id(); // Auto-increment ID
            $table->unsignedBigInteger('product_id'); // Foreign key to products table
            $table->integer('cart_qty'); // Quantity of the product in the favourites (optional, may not be needed)
            $table->enum('action', ['0', '1'])->default('0'); // Enum for action (active or inactive)
            $table->timestamp('c_date')->useCurrent(); // Creation timestamp
            $table->unsignedBigInteger('user_id'); // Foreign key to the users table (user who added the favourite)
            $table->string('size'); // Size of the product (e.g., 'M', 'L', 'XL')
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
        Schema::dropIfExists('user_favourites');
    }
}
