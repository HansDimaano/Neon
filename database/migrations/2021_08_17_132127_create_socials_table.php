<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSocialsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Use the Schema facade to create the "socials" table
        Schema::create('socials', function (Blueprint $table) {
            $table->id(); // Auto-incrementing ID column
            $table->bigInteger('user_id')->length(20)->unsigned(); // Foreign key column for the associated user
            $table->string('provider', 30); // Provider column for the social platform
            $table->string('social_id', 150)->nullable()->default(null); // Nullable social ID column
            $table->timestamp('verified_at')->nullable()->default(null); // Nullable timestamp column for verification
            $table->timestamps(); // Created at and updated at timestamps

            // Define a foreign key constraint on the 'user_id' column referencing the 'id' column of the 'users' table
            // with the 'cascade' option for automatic deletion of associated socials when a user is deleted
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
        // Drop the "socials" table if it exists
        Schema::dropIfExists('socials');
    }
};

