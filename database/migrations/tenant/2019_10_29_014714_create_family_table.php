<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFamilyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('family', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('employee_id',50);
            $table->string('family_name',100);
            $table->string('birth_place',50);
            $table->date('birth_date');
            $table->string('gender',50);
            $table->string('image_file_path',100)->nullable();
            $table->string('relation',50);
            $table->string('phone_number',50)->nullable();
            $table->string('job',100)->nullable();
            $table->string('family_number_KK',50)->nullable();
            $table->string('bpjs_kesehatan_number',50)->nullable();
            $table->integer('child_number');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('family');
    }
}
