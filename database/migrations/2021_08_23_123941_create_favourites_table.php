<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFavouritesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Use the Schema facade to create the "favourites" table
        Schema::create('favourites', function (Blueprint $table) {
            $table->bigInteger('user_id')->unsigned(); // Foreign key column for the associated user
            $table->bigInteger('card_id')->unsigned(); // Foreign key column for the associated card
            $table->timestamps(); // Created at and updated at timestamps

            $table->primary(['user_id', 'card_id']); // Define a composite primary key

            // Define foreign key constraints on the 'user_id' and 'card_id' columns referencing the 'id' columns
            // of the 'users' and 'cards' tables respectively, with the 'cascade' option for automatic deletion
            // of associated records when a user or card is deleted
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
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
        // Drop the "favourites" table if it exists
        Schema::dropIfExists('favourites');
    }
};

