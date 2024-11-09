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
    Schema::create('user_profiles', function (Blueprint $table) {
        $table->id();
        $table->bigInteger('user_id');
        $table->string('username');
        $table->string('email')->unique();
        $table->string('headline')->nullable();;
        $table->string('website')->nullable();
        $table->string('linkedin_id')->nullable();
        $table->text('description')->nullable();
        $table->text('experience')->nullable();
        $table->text('education')->nullable();
        $table->string('skills')->nullable();;
        $table->string('file')->nullable(); 
        $table->string('profile_pic')->nullable();  // For file upload
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_profiles');
    }
};
