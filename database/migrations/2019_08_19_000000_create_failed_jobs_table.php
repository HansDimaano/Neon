<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFailedJobsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Use the Schema facade to create the "failed_jobs" table
        Schema::create('failed_jobs', function (Blueprint $table) {
            $table->id(); // Auto-incrementing ID column
            $table->string('uuid')->unique(); // Unique UUID column
            $table->text('connection'); // Connection column
            $table->text('queue'); // Queue column
            $table->longText('payload'); // Payload column to store job data
            $table->longText('exception'); // Exception column to store failure details
            $table->timestamp('failed_at')->useCurrent(); // Timestamp column for when the job failed
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Drop the "failed_jobs" table if it exists
        Schema::dropIfExists('failed_jobs');
    }
}

