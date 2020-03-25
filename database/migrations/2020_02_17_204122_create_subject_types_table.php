<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubjectTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subject_types', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
            $table->string('type_en');
            $table->string('type_ru');
            $table->string('type_kk');
            $table->integer('o_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('subject_types');
    }
}
