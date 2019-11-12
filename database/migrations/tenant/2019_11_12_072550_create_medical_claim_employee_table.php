<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMedicalClaimEmployeeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('medical_claim_employee', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string("submission_number",50);
            $table->string("employee_id",50);
            $table->date("claim_date");
            $table->date("approval_date")->nullable();
            $table->string("approval_by")->nullable();
            $table->enum("claim_type",["medical","maternity","glasses"]);
            $table->string("claim_purpose",50);
            $table->string("clinic_name",50);
            $table->text("description");
            $table->enum("approval_status",["approved","rejected"])->nullable();
            $table->decimal("total_claim_amount",13,4);
            $table->decimal("total_claim_approved",13,4)->nullable();
            $table->text("approval_description")->nullable();
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
        Schema::dropIfExists('medical_claim_employee');
    }
}
