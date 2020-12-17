<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSplDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('spl_detail', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string("spl_number",50);
            $table->string("employee_id",50);
            $table->time("overtime_hour");
            $table->time("overtime_hour_real")->nullable();
            $table->bigInteger("user_input")->nullable();
            $table->bigInteger("user_edit");
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
        Schema::dropIfExists('spl_detail');
    }
}
