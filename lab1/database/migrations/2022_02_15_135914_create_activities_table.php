<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateActivitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('activities', function (Blueprint $table) {
            $table->id();
            $table->date('Date');
            $table->integer('Course');
            $table->unsignedBigInteger('GroupId');
            $table->unsignedBigInteger('DisciplineId');
            $table->integer('Lections')->nullable();
            $table->integer('Practics')->nullable();
            $table->integer('Labs')->nullable();
            $table->integer('Modules')->nullable();
            $table->integer('SemesterConsultations')->nullable();
            $table->integer('ExamConsultations')->nullable();
            $table->integer('Passes')->nullable();
            $table->integer('Exams')->nullable();
            $table->integer('Courseworks')->nullable();
            $table->integer('BachelorsFQW')->nullable();
            $table->integer('MastersFQW')->nullable();
            $table->integer('PracticsManagement')->nullable();
            $table->integer('GrandExams')->nullable();
            $table->integer('FQWReviewing')->nullable();
            $table->integer('FQWPresenting')->nullable();
            $table->integer('AspirantsManagement')->nullable();
            $table->integer('Others')->nullable();
            $table->timestamps();
            $table->foreign('GroupId')->references('id')->on('groups');
            $table->foreign('DisciplineId')->references('id')->on('disciplines');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('activities');
    }
}
