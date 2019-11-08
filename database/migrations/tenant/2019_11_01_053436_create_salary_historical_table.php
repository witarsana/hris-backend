<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalaryHistoricalTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('salary_historical', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string("employee_id",50);
            $table->string("salary_code",50);
            $table->decimal("old_amount",13,4);
            $table->decimal("new_amount",13,4);
            $table->date("change_date");
            $table->date("active_date")->nullable();
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
        Schema::dropIfExists('salary_historical');
    }
}
