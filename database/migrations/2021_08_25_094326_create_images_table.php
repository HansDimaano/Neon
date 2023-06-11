<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Use the Schema facade to create the "images" table
        Schema::create('images', function (Blueprint $table) {
            $table->id(); // Auto-incrementing primary key column
            $table->string('belongs', 4)->comment('USR/CMT'); // A string column to indicate whether the image belongs to a user or a comment
            $table->bigInteger('belongs_id')->comment('Points the id of the owner'); // Foreign key column pointing to the owner's ID
            $table->text('name'); // Text column to store the name of the image
            $table->timestamps(); // Created at and updated at timestamps
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Drop the "images" table if it exists
        Schema::dropIfExists('images');
    }
}

