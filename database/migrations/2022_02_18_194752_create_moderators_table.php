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
        Schema::create('moderators', function (Blueprint $table) {
            $table->increments("moderatorId");
            $table->integer("userId")->unsigned()->nullable();
            $table->string("firstName");
            $table->string("lastName");
            $table->string("moderatorRole");
            $table->integer("moderatorCreatedBy")->unsigned()->nullable(); // l superAdmin li Créaah
            $table->timestamps(); 

           
        });

        Schema::table('moderators', function(Blueprint $table) {
            $table->foreign('userId')->references('userId')->on('users');
            $table->foreign('moderatorCreatedBy')->references('superAdminId')->on('super_admins');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('moderators');
    }
};
