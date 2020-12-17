<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBpjsRatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bpjs_rates', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('code',50);
            $table->string("description");
            $table->decimal("jhtp",5,2);
            $table->decimal("jhtk",5,2);
            $table->decimal("jk",5,2);
            $table->decimal("jkk",5,2);
            $table->decimal("jpk_lajang",5,2);
            $table->decimal("jpk_nikah",5,2);
            $table->decimal("bpjskesp",5,2);
            $table->decimal("bpjskesk",5,2);
            $table->decimal("max_salary_pension",13,4);
            $table->decimal("max_salary_medical",13,4);
            $table->decimal("pension_company",5,2);
            $table->decimal("pension_employees",5,2);
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
        Schema::dropIfExists('bpjs_rates');
    }
}
