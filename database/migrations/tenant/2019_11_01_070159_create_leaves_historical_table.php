<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLeavesHistoricalTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('leaves_historical', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('employee_id',50);
            $table->date('start_date');
            $table->date('end_date');
            $table->integer('leave_amount_days');
            $table->string('leave_type',50);
            $table->text('description');
            $table->tinyInteger('outside_city_status')->nullable();
            $table->string('emergency_number',50);
            $table->string('delegation_job_to',50)->nullable();
            $table->string('approved_by',50)->nullable();
            $table->date('approved_date')->nullable();
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
        Schema::dropIfExists('leaves_historical');
    }
}
