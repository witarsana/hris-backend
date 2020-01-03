<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrganizationLevelTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('organization_level', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('org_level_code',50);
            $table->string('org_level_name',100);
            $table->text('org_level_desc')->nullable();
            $table->integer('sorting_number');
            $table->bigInteger('user_input');
            $table->bigInteger('user_edit');
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
        Schema::dropIfExists('organization_level');
    }
}
