<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFollowsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Use the Schema facade to create the "follows" table
        Schema::create('follows', function (Blueprint $table) {
            $table->bigInteger('card_id')->unsigned(); // Foreign key column for the associated card
            $table->bigInteger('follow_id')->unsigned(); // Foreign key column for the associated user being followed
            $table->boolean('is_accepted')->default(true); // Indicates whether the follow request is accepted or not
            $table->timestamps(); // Created at and updated at timestamps

            $table->primary(['card_id', 'follow_id']); // Define a composite primary key

            // Define foreign key constraints on the 'follow_id' and 'card_id' columns referencing the 'id' columns
            // of the 'users' and 'cards' tables respectively, with the 'cascade' option for automatic deletion
            // of associated records when a user or card is deleted
            $table->foreign('follow_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('card_id')->references('id')->on('cards')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Drop the "follows" table if it exists
        Schema::dropIfExists('follows');
    }
};
