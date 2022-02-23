<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTimespansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('timespans', function (Blueprint $table) {
            $table->id();
            $table->integer('Year');
            $table->unsignedBigInteger('MonthId');
            $table->unsignedBigInteger('WorkFormatId');
            $table->unsignedBigInteger('ActivityId');
            $table->timestamps();
            $table->foreign('MonthId')->references('id')->on('months');
            $table->foreign('WorkFormatId')->references('id')->on('workformats');
            $table->foreign('ActivityId')->references('id')->on('activities');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('timespans');
    }
}
