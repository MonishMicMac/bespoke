<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductRatingAfterDeliveryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_rating_after_delivery', function (Blueprint $table) {
            $table->id(); // Auto-increment ID
            $table->unsignedBigInteger('user_id'); // Foreign key to users table
            $table->integer('rating'); // Rating given by the user (e.g., 1 to 5)
            $table->string('images')->nullable(); // Images uploaded for the review (nullable)
            $table->text('comments')->nullable(); // Comments left by the user (nullable)
            $table->enum('action', ['0', '1'])->default('0'); // Enum for action (active or inactive)
            $table->timestamp('c_date')->useCurrent(); // Creation timestamp
            $table->unsignedBigInteger('product_id'); // Foreign key to the product being rated
            $table->timestamps(); // Adds created_at and updated_at

            // Foreign key constraints
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_rating_after_delivery');
    }
}
