<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->bigIncrements('id_number');
            $table->string('company_id');
            $table->string('company_name');
            $table->string('company_email');
            $table->string('company_password');
            $table->string('db_host');
            $table->string('db_port');
            $table->string('db_user');
            $table->string('db_password');
            $table->string('user_input');
            $table->string('user_edit');
            $table->string('user_delete');
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
        Schema::dropIfExists('companies');
    }
}
