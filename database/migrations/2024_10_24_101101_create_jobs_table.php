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
        Schema::create('jobs', function (Blueprint $table) {
            $table->id(); // Auto-incrementing primary key
            $table->string('job_title');
            $table->string('company_name');
            $table->text('job_description');
            $table->string('job_location');
            $table->string('salary'); // Salary with precision of 10 and scale of 2
            $table->date('application_deadline');
            $table->string('job_type'); // Full-time, Part-time, etc.
            $table->string('experience_level'); // Junior, Mid, Senior
            $table->text('required_skills');
            $table->timestamps(); // Created at and Updated at columns
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('jobs');
    }
};
