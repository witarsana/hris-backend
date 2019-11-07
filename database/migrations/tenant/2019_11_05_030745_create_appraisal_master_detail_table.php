<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAppraisalMasterDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('appraisal_master_detail', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string("appraisal_detail_code",50);
            $table->string("appraisal_name",50);
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
        Schema::dropIfExists('appraisal_master_detail');
    }
}
