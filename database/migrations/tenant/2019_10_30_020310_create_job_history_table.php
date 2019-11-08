<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJobHistoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('job_history', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('employee_id',50);
            $table->string('company_name',50);
            $table->string('business_fields',50)->nullable();
            $table->string('departement',50)->nullable();
            $table->string('position',50);
            $table->date('from_date');
            $table->date('until_date');
            $table->string("description",50)->nullable();
            $table->string('job_desc',50)->nullable();
            $table->string('duration_of_position',100)->nullable();
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
        Schema::dropIfExists('table_job_history');
    }
}
