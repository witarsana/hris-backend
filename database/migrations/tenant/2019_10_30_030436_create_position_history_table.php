<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePositionHistoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('position_history', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string("employee_id",50);
            $table->string("old_position",100);
            $table->string("new_position",100);
            $table->date("promotion_date");
            $table->string("old_position_duration",100)->nullable();
            $table->text("description");
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
        Schema::dropIfExists('position_history');
    }
}
