<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMasterTrainingTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('master_training_types', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('training_type_code',50);
            $table->string('training_type_name',100);
            $table->bigInteger('user_input')->nullable();
            $table->bigInteger('user_edit')->nullable();
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
        Schema::dropIfExists('master_training_types');
    }
}
