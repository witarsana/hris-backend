<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWorkshiftMasterDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('workshift_master_data', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string("shift_code",50);
            $table->string("shift_name",100);
            $table->time("begin_time");
            $table->time("end_time");
            $table->text("description")->nullable();
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
        Schema::dropIfExists('workshift_master_data');
    }
}
