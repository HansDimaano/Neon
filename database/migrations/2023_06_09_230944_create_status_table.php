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
        // Use the Schema facade to create the "status" table
        Schema::create('status', function (Blueprint $table) {
            $table->id(); // Auto-incrementing primary key column
            $table->bigInteger('user_id')->length(20)->unsigned(); // Big integer column to store the user ID
            $table->longText('body')->nullable()->default(null); // Long text column to store the status body, can be nullable

            $table->timestamps(); // Created at and updated at timestamps

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade'); // Foreign key constraint referencing the "id" column in the "users" table
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Drop the "status" table if it exists
        Schema::dropIfExists('status');
    }
};

