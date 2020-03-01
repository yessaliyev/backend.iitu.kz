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
            $table->integer('o_teacher_id');
            $table->integer('o_subject_id');
            $table->integer('o_subject_type_id');
            $table->integer('o_group_id');
            $table->integer('o_room_id');
            $table->integer('o_appointment_id');
            $table->integer('o_regalia_id');
            $table->integer('o_time_id');
            $table->integer('o_day_id');
            $table->integer('o_id');
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
