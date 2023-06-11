<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVariablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Use the Schema facade to create the "variables" table
        Schema::create('variables', function (Blueprint $table) {
            $table->id(); // Auto-incrementing primary key column
            $table->string('name', 30)->unique()->comment('variable name'); // String column to store the name of the variable, with a length of 30 characters
            $table->text('value'); // Text column to store the value of the variable
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
        // Drop the "variables" table if it exists
        Schema::dropIfExists('variables');
    }
}

