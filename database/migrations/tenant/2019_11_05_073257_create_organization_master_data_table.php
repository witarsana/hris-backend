<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrganizationMasterDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('organization_master_data', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string("org_code",50);
            $table->string("org_name",100);
            $table->string("dependent_to",50)->nullable();
            $table->enum('dependent_status', ['dependant', 'not dependant']);
            $table->enum('mandatory_status', ['mandatory', 'not mandatory']);
            $table->enum('user_management_status', ['related', 'not related']);
            $table->integer("sorting_number");
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
        Schema::dropIfExists('organization_master_data');
    }
}
