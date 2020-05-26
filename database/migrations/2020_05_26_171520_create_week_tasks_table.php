<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWeekTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('week_tasks', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
            $table->integer('week_id');
            $table->integer('subject_id');
            $table->string('title');
            $table->text('content')->nullable();
            $table->text('filenames')->nullable();
            $table->integer('status')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('week_tasks');
    }
}
