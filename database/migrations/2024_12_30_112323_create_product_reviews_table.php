<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductReviewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_reviews', function (Blueprint $table) {
            $table->id(); // Auto-increment ID
            $table->unsignedBigInteger('product_id'); // Foreign key to products table
            $table->string('review_topic'); // Topic of the review
            $table->text('description'); // Review description
            $table->enum('action', ['0', '1'])->default('0'); // Enum for action (active or inactive)
            $table->timestamp('c_date')->useCurrent(); // Creation timestamp
            $table->unsignedBigInteger('user_id'); // Foreign key to the user who posted the review
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
        Schema::dropIfExists('product_reviews');
    }
}
