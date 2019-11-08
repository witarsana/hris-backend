<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAttendanceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attendance', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string("employee_id",50);
            $table->date("date");
            $table->time("time_in");
            $table->time("time_out");
            $table->string("shift_code",50);
            $table->time("total_work_hour");
            $table->enum("day_type",["workday","holiday"]);
            $table->decimal("overtime_value_by_SPL",18,2)->nullable();
            $table->decimal("overtime_value_by_att",18,2)->nullable();
            $table->decimal("overtime_value_by_approval",18,2)->nullable();
            $table->decimal("overtime_value_conversion",18,2)->nullable();
            $table->enum("late_status",["normal","late"]);
            $table->time("late_minutes");
            $table->enum("early_out_status",["normal","early"]);
            $table->time("early_out_minutes");
            $table->text("description")->nullable();
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
        Schema::dropIfExists('attendance');
    }
}
