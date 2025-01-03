<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id(); // Auto-increment ID
            $table->string('product_name'); // Name of the product
            $table->string('category'); // Main category
            $table->string('subcategory')->nullable(); // Optional subcategory
            $table->decimal('actual_price', 10, 2); // Actual price with 2 decimal places
            $table->decimal('offer_price', 10, 2)->nullable(); // Discounted price
            $table->enum('gender', ['male', 'female', 'unisex']); // Product's target gender
            $table->boolean('is_customizable')->default(false); // Customizable option
            $table->text('description')->nullable(); // Detailed product description
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
        Schema::dropIfExists('products');
    }
}
