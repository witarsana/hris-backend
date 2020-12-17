<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMedicalCheckUpEmployeeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('medical_check_up_employee', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string("employee_id",50);
            $table->enum("mcu_type",["awal","tahunan","lainnya"]);
            $table->integer("year");
            $table->date("mcu_date");
            $table->integer("age")->nullable();
            $table->string("body_weight",50)->nullable();
            $table->string("body_height",50)->nullable();
            $table->string("imtbmi",50)->nullable();
            $table->enum("right_eye_visus",["normal","positif","negatif"])->nullable();
            $table->enum("left_eye_visus",["normal","positif","negatif"])->nullable();
            $table->enum("color_blind",["negatif","positif"])->nullable();
            $table->string("physical",100)->nullable();
            $table->string("pushup",50)->nullable();
            $table->string("blood_pressure1",50)->nullable();
            $table->string("blood_pressure2",50)->nullable();
            $table->string("respiratory_1",50)->nullable();
            $table->string("respiratory_2",50)->nullable();
            $table->enum("urine_lab",["normal","abnormal"])->nullable();
            $table->enum("blood_lab",["normal","abnormal"])->nullable();
            $table->enum("hbsag",["reaktif","non reaktif"])->nullable();
            $table->enum("radiology",["normal","abnormal"])->nullable();
            $table->string("audiometry",50)->nullable();
            $table->enum("blood_type",["a","b","ab","o"])->nullable();
            $table->enum("rhesus",["positif","negatif"])->nullable();
            $table->enum("ekg",["normal","abnormal","none"])->nullable();
            $table->text("conclusion")->nullable();
            $table->enum("teeth",["normal","abnormal"])->nullable();
            $table->text("history_of_disease")->nullable();
            $table->bigInteger("user_input")->nullable();
            $table->bigInteger("user_edit")->nullable();
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
        Schema::dropIfExists('medical_check_up_employee');
    }
}
