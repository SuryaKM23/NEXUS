<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('job_applied', function (Blueprint $table) {
            $table->id(); // Auto-incrementing ID
            $table->string('name'); // Name of the applicant
            $table->string('email')->unique(); // Email address, must be unique
            $table->string('phone'); // Phone number
            $table->string('degree'); // Degree of the applicant
            $table->text('skills'); // Skills as text
            $table->text('experience'); // Experience details as text
            $table->string('resume'); // Path to the uploaded resume
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
        Schema::dropIfExists('job_applied');
    }
};
