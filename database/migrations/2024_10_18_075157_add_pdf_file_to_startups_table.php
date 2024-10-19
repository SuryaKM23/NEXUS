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
        Schema::table('startups', function (Blueprint $table) {
            $table->string('pdf_file')->nullable(); // You can change the type if needed
        });
    }

    public function down()
    {
        Schema::table('startups', function (Blueprint $table) {
            $table->dropColumn('pdf_file');
        });
    }
};