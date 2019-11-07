<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalaryMasterDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('salary_master_data', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string("salary_code",50);
            $table->string("salary_name",100);
            $table->enum("income_deduction_status",["income","deduction"]);
            $table->enum("active_status",["active","non active"]);
            $table->enum("regular_iregular_status",["regular","iregular"]);
            $table->enum("attendance_related_status",["related","non related"]);
            $table->enum("thr_related_status",["related","non related"]);
            $table->enum("overtime_related_status",["related","non related"]);
            $table->enum("tax_related_status",["related","non related"]);
            $table->enum("bpjstk_related_status",["related","non related"]);
            $table->enum("bpjskes_related_status",["related","non related"]);
            $table->string("description",100)->nullable();
            $table->bigInteger('user_input')->nullable();
            $table->bigInteger('user_edit')->nullable();
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
        Schema::dropIfExists('salary_master_date');
    }
}
