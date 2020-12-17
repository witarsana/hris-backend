<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeeOrganizationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employee_organization', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string("employee_id",50);
            $table->string("org_level_code",80);
            $table->string("org_code",50);
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
        Schema::dropIfExists('employee_organization');
    }
}
