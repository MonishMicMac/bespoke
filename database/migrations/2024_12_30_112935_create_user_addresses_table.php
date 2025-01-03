<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_addresses', function (Blueprint $table) {
            $table->id(); // Auto-increment ID
            $table->unsignedBigInteger('user_id'); // Foreign key to users table
            $table->string('name'); // Name of the person
            $table->string('phone'); // Phone number
            $table->string('pincode'); // Pincode
            $table->string('state'); // State
            $table->string('city'); // City
            $table->string('house_building_name'); // House/Building Name
            $table->string('area_colony'); // Area/Colony
            $table->string('landmark_nearby'); // Landmark/Nearby Reference
            $table->enum('type', ['home', 'work']); // Type of address (home or work)
            $table->string('lat'); // Latitude
            $table->string('long'); // Longitude
            $table->enum('action', ['0', '1'])->default('0'); // Enum for action (active or inactive)
            $table->timestamp('c_date')->useCurrent(); // Creation timestamp
            $table->timestamps(); // Adds created_at and updated_at

            // Foreign key constraint
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_addresses');
    }
}
