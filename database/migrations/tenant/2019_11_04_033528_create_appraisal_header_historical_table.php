<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAppraisalHeaderHistoricalTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('appraisal_header_historical', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string("appraisal_code",50);
            $table->string("employee_id",50);
            $table->integer("total_point");
            $table->integer("appraisal_month");
            $table->integer("appraisal_year");
            $table->text("description");
            $table->bigInteger("user_input");
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
        Schema::dropIfExists('appraisal_header_historical');
    }
}
