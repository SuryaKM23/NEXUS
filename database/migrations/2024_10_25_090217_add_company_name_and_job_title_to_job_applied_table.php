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
        $table->string('company_name')->nullable();
        $table->string('job_title')->nullable();
    });
}

public function down()
{
    Schema::table('job_applied', function (Blueprint $table) {
        $table->dropColumn(['company_name', 'job_title']);
    });
}
};
