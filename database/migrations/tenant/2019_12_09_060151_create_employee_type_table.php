<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeeTypeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employee_type', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('employee_type_code',50);
            $table->string('employee_type_name',100);
            $table->text('description')->nullable();
            $table->bigInteger('user_input');
            $table->bigInteger('user_edit');
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
        Schema::dropIfExists('employee_type');
    }
}
