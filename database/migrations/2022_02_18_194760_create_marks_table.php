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
        Schema::create('marks', function (Blueprint $table) {
            $table->string('markId', 250)->primary();//studentId.courseId
            $table->integer("courseId")->unsigned();
            $table->float("mark");
            $table->integer("studentId")->unsigned();
            $table->timestamps();

            
        });

        Schema::table('marks', function(Blueprint $table) {
            $table->foreign('courseId')->references('courseId')->on('courses');
            $table->foreign('studentId')->references('studentId')->on('students');
        });
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('marks');
    }
};
