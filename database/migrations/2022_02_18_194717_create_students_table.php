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
        Schema::create('students', function (Blueprint $table) {
            $table->increments("studentId");
            $table->integer("userId")->unsigned()->nullable();
            $table->integer("currentSemester")->unsigned()->nullable();
            $table->string("firstName");
            $table->string("lastName");
            $table->string("fullName");
            $table->integer("studentPromo");
            $table->string("studentGroup");
            $table->integer("studentMajor")->unsigned()->nullable();
            $table->timestamps();   
            
           
        });

        Schema::table('students', function(Blueprint $table) {
            $table->foreign('userId')->references('userId')->on('users');
            $table->foreign('currentSemester')->references('semesterId')->on('semesters');
            $table->foreign('studentMajor')->references('majorId')->on('majors');
        });

        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('students');
    }
};
