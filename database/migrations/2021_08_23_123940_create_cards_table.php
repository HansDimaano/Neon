<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Use the Schema facade to create the "cards" table
        Schema::create('cards', function (Blueprint $table) {
            $table->id(); // Auto-incrementing ID column
            $table->bigInteger('user_id')->length(20)->unsigned(); // Foreign key column for the associated user
            $table->string('card_no', 50)->nullable(); // Nullable column for card number
            $table->string('card_name', 50)->nullable(); // Nullable column for card name
            $table->json('permissions')->nullable(); // Nullable column for permissions stored as JSON
            $table->timestamps(); // Created at and updated at timestamps

            // Define a foreign key constraint on the 'user_id' column referencing the 'id' column of the 'users' table
            // with the 'cascade' option for automatic deletion of associated cards when a user is deleted
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
        // Drop the "cards" table if it exists
        Schema::dropIfExists('cards');
    }
};
