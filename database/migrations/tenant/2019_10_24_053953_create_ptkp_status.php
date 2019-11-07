<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePtkpStatus extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ptkp_status', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('ptkp_code',50);
            $table->string('description',50);
            $table->integer('status');
            $table->integer('dependents');
            $table->decimal('ptkp_value',13,4);
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
        Schema::dropIfExists('ptkp_status');
    }
}
