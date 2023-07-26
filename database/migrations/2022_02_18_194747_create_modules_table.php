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
        Schema::create('modules', function (Blueprint $table) {
            $table->increments("moduleId");
            $table->string("moduleName");
            $table->float("moduleCoeff", 8, 3);
            $table->string("moduleAbbreviation");
            $table->integer("moduleMajor")->unsigned()->nullable();
            $table->timestamps();


        });

        Schema::table('modules', function(Blueprint $table) {
            $table->foreign('moduleMajor')->references('majorId')->on('majors');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('modules');
    }
};
