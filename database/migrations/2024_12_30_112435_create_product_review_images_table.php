<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductReviewImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_review_images', function (Blueprint $table) {
            $table->id(); // Auto-increment ID
            $table->unsignedBigInteger('product_review_id'); // Foreign key to product_reviews table
            $table->enum('action', ['active', 'inactive'])->default('active'); // Enum for action (active or inactive)
            $table->timestamp('c_date')->useCurrent(); // Creation timestamp
            $table->timestamps(); // Adds created_at and updated_at

            // Foreign key constraint
            $table->foreign('product_review_id')->references('id')->on('product_reviews')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_review_images');
    }
}
