<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrainingHistoricalTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('training_historical', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('employee_id',50);
           // $table->foreign('employee_id')->references('employee_id')->on('pegawai');
            $table->string('training_name',100);
            $table->string('organizer',100);
            $table->string('trainer_name',100)->nullable();
            $table->string('instructor',100)->nullable();
            $table->string('certification_type',50)->nullable();
            $table->date('start_date');
            $table->date('end_date');
            $table->string('pre_test_score',50)->nullable();
            $table->string('post_test_score',50)->nullable();
            $table->string('standard_score',50)->nullable();
            $table->string('evaluation',255)->nullable();
            $table->text('description',50)->nullable();
            $table->string('certificate_number',255)->nullable();
            $table->bigInteger('training_type_code');
            //$table->foreign('training_type_code')->references('id')->on('master_training_type');
            $table->bigInteger('user_input');
            //$table->foreign('user_input')->references('id')->on('users');
            $table->bigInteger('user_edit');
            //$table->foreign('user_edit')->references('id')->on('users');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('training_historical');
    }
}
