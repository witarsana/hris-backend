<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLoanInstallmentsHistoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('loan_installments_history', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string("employee_id",50);
            $table->string("loan_number",50);
            $table->date("intallments_date");
            $table->decimal("installments_amount",13,4);
            $table->string("description",50)->nullable();
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
        Schema::dropIfExists('loan_installments_history');
    }
}
