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
        Schema::create('courses', function (Blueprint $table) {
            $table->increments("courseId");
            $table->integer("moduleId")->unsigned()->nullable();
            $table->string("courseName");
            $table->string("courseAbbreviation");
            $table->float("courseCoeff", 8, 2);
            $table->timestamps();

            
        });

        Schema::table('courses', function(Blueprint $table) {
            $table->foreign('moduleId')->references('moduleId')->on('modules');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('courses');
    }
};
