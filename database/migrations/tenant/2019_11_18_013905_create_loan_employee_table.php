<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLoanEmployeeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('loan_employee', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string("employee_id",50);
            $table->string("loan_number",50);
            $table->date("loan_date");
            $table->decimal("loan_amount",13,4);
            $table->decimal("loan_interest",5,2);
            $table->decimal("installments",13,4);
            $table->decimal("total_paid",13,4)->nullable();
            $table->enum("loan_source",["Company","Koperasi"])->nullable();
            $table->integer("period");
            $table->decimal("total_loan",13,4)->nullable();
            $table->enum("loan_status",["On Progress","Paid Off"])->nullable();
            $table->date("process_date")->nullable();
            $table->enum("process_flag",["0","1"])->nullable();
            $table->string("description",50)->nullable();
            $table->string("approved_by",50)->nullable();
            $table->string("submitted_by",50)->nullable();
            $table->string("collateral",100)->nullable();
            $table->enum("interest_type",["Flat","Efektif"]);
            $table->decimal("interest_of_installments",13,4)->nullable();
            $table->decimal("remaining_loan",13,4)->nullable();
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
        Schema::dropIfExists('loan_employee');
    }
}
