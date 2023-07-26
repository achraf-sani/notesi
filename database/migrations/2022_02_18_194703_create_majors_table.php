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
        Schema::create('majors', function (Blueprint $table) {
            $table->increments("majorId");
            $table->string("majorName");
            $table->integer("semesterId")->unsigned()->nullable();
            $table->string("majorAbbreviation");
            $table->timestamps();

           
        });

        Schema::table('majors', function(Blueprint $table) {
            $table->foreign('semesterId')->references('semesterId')->on('semesters');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('majors');
    }
};
