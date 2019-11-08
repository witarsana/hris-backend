<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAppraisalDetailHistoricalTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('appraisal_detail_historical', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string("appraisal_detail_code",50);
            $table->string("appraisal_code",50);   
            $table->integer("point"); 
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
        Schema::dropIfExists('appraisal_detail_historical');
    }
}
