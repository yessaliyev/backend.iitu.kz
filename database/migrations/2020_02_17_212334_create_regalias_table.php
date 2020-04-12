<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRegaliasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('regalias', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
            $table->string('regalia_en')->nullable();
            $table->string('regalia_ru')->nullable();
            $table->string('regalia_kk')->nullable();
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
        Schema::dropIfExists('regalias');
    }
}
