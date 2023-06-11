<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRatingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Use the Schema facade to create the "ratings" table
        Schema::create('ratings', function (Blueprint $table) {
            $table->id(); // Auto-incrementing primary key column
            $table->bigInteger('from_id')->unsigned(); // Foreign key column for the ID of the user giving the rating
            $table->bigInteger('to_id')->unsigned(); // Foreign key column for the ID of the card receiving the rating
            $table->integer('rating')->unsigned()->default(0); // Unsigned integer column to store the rating value
            $table->text('comment')->nullable(); // Text column to store an optional comment
            $table->boolean('is_pinned')->default(false); // Boolean column to indicate whether the rating is pinned
            $table->timestamps(); // Created at and updated at timestamps

            // Define foreign key constraints
            $table->foreign('from_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('to_id')->references('id')->on('cards')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Drop the "ratings" table if it exists
        Schema::dropIfExists('ratings');
    }
}

