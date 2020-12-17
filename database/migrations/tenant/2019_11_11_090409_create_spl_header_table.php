<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSplHeaderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('spl_header', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string("spl_number",50);
            $table->date("overtime_date");
            $table->enum("approval_status",["approved","rejected"])->nullable();
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
        Schema::dropIfExists('spl_header');
    }
}
