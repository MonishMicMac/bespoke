<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductSizeDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_size_details', function (Blueprint $table) {
            $table->id(); // Auto-increment ID
            $table->unsignedBigInteger('product_id'); // Foreign key to products table
            $table->string('detail_name'); // Name of the detail (e.g., size, color)
            $table->string('details_value'); // Value of the detail (e.g., XL, Red)
            $table->enum('action')->default(true); // Action status (true for active)
            $table->timestamp('c_date')->useCurrent(); // Creation timestamp
            $table->timestamps(); // Adds created_at and updated_at

            // Foreign key constraint
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
        Schema::dropIfExists('product_size_details');
    }
}
