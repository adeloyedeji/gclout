<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('profiles', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->integer('role')->default(1);
            $table->date('date_of_birth')->nullable();
            $table->text('about')->nullable();
            $table->text('address')->nullable();
            $table->string('ward')->nullable();
            $table->string('job')->nullable();
            $table->integer('state_id')->unsigned()->nullable();
            $table->integer('lga_id')->unsigned()->nullable();
            $table->integer('country_id')->unsigned()->nullable();
            $table->integer('residence')->unsigned()->nullable();
            $table->string('phone_number')->nullable();
            $table->boolean('blocked')->default(0);
            $table->boolean('account_status')->default(0);
            $table->boolean('online_status')->default(0);
            $table->integer('total_login')->default(0);
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
        Schema::dropIfExists('profiles');
    }
}
