<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id(); // Auto-incrementing ID
            $table->string('fname'); // First name
            $table->string('lname'); // Last name
            $table->string('email')->unique(); // Unique email address
            $table->string('phone')->unique(); // Unique phone number
            $table->string('username')->unique(); // Unique username
            $table->timestamp('email_verified_at')->nullable(); // Email verification timestamp (nullable)
            $table->string('password'); // Password (hashed)
            $table->rememberToken(); // Remember token for "remember me" functionality
            $table->text('bio')->nullable(); // Nullable bio (text field)
            $table->bigInteger('total_rating')->nullable()->default(0); // Nullable total rating (default: 0)
            $table->bigInteger('rate_counter')->nullable()->default(0); // Nullable rate counter (default: 0)
            $table->bigInteger('views')->nullable()->default(0); // Nullable views count (default: 0)
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
        Schema::dropIfExists('users'); // Drop the "users" table if it exists
    }
}

