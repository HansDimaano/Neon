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
        // Use the Schema facade to create the "personal_access_tokens" table
        Schema::create('personal_access_tokens', function (Blueprint $table) {
            $table->id(); // Auto-incrementing ID column
            $table->morphs('tokenable'); // Polymorphic relationship column
            $table->string('name'); // Name column for the token
            $table->string('token', 64)->unique(); // Unique token column (64 characters long)
            $table->text('abilities')->nullable(); // Abilities column to store token abilities
            $table->timestamp('last_used_at')->nullable(); // Timestamp column for the last usage of the token
            $table->timestamp('expires_at')->nullable(); // Timestamp column for token expiration
            $table->timestamps(); // Created at and updated at timestamps
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Drop the "personal_access_tokens" table if it exists
        Schema::dropIfExists('personal_access_tokens');
    }
};

