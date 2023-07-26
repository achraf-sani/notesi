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
        Schema::create('super_admins', function (Blueprint $table) {
            $table->increments('superAdminId');
            $table->integer('userId')->unsigned()->nullable();
            $table->string('firstName');
            $table->string('lastName');
            $table->string('superAdminAvatar');
            $table->string('superAdminRole');
            $table->timestamps();
        });

        Schema::table('super_admins', function(Blueprint $table) {
            $table->foreign('userId')->references('userId')->on('users');
        });
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('super_admins');
    }
};
