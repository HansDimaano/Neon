<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Use the Schema facade to create the "comments" table
        Schema::create('comments', function (Blueprint $table) {
            $table->id(); // Auto-incrementing primary key column
            $table->bigInteger('user_id')->length(20)->unsigned(); // Big integer column to store the user ID
            $table->bigInteger('status_id')->length(20)->unsigned(); // Big integer column to store the status ID
            $table->text('body')->nullable()->default(null); // Text column to store the comment body, can be nullable

            $table->timestamps(); // Created at and updated at timestamps

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade'); // Foreign key constraint referencing the "id" column in the "users" table
            $table->foreign('status_id')->references('id')->on('status')->onDelete('cascade'); // Foreign key constraint referencing the "id" column in the "status" table
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Drop the "comments" table if it exists
        Schema::dropIfExists('comments');
    }
};

