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
        Schema::table('job_applied', function (Blueprint $table) {
            // Drop the unique constraint
            $table->dropUnique(['email']);
        });
    }

    public function down()
    {
        Schema::table('job_applied', function (Blueprint $table) {
            // Re-add the unique constraint if you ever need to roll back
            $table->unique('email');
        });
    }
};
