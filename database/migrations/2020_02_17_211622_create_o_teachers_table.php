<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOTeachersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('o_teachers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
            $table->string('teacher_en');
            $table->string('teacher_ru');
            $table->string('teacher_kk');
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
        Schema::dropIfExists('o_teachers');
    }
}
