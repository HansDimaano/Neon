<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// Create a new anonymous class that extends the Migration class
return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Use the Schema facade to create the "password_reset_tokens" table
        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary(); // Primary key column (email)
            $table->string('token'); // Token column
            $table->timestamp('created_at')->nullable(); // Nullable created_at column
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Drop the "password_reset_tokens" table if it exists
        Schema::dropIfExists('password_reset_tokens');
    }
};
