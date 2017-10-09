<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExercisesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('exercises', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->integer('body_part_id');
        });

        //should be alphabetical order, "E" first before "J"
        Schema::create('exercise_journal', function (Blueprint $table) {
            $table->integer('journal_id');
            $table->integer('exercise_id');
            $table->string('weight');
            $table->string('sets');
            $table->string('reps');
            //set a primary key as journal_id and exercise_id
            $table->primary(['journal_id', 'exercise_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('exercises');
    }
}
