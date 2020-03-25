<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSchedulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('schedules', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
            $table->integer('teacher_id');
            $table->integer('subject_id');
            $table->integer('subject_type_id');
            $table->integer('group_id');
            $table->integer('room_id');
            $table->integer('appointment_id');
            $table->integer('regalia_id');
            $table->integer('time_id');
            $table->integer('day_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('schedules');
    }
}
