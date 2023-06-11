<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePasswordResetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Use the Schema facade to create the "password_resets" table
        Schema::create('password_resets', function (Blueprint $table) {
            $table->string('email')->index(); // Index the email column for faster lookups
            $table->string('token'); // Token column
            $table->timestamp('created_at')->nullable(); // Nullable created_at column
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Drop the "password_resets" table if it exists
        Schema::dropIfExists('password_resets');
    }
}

