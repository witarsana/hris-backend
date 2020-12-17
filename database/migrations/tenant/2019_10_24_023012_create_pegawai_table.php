<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePegawaiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pegawai', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('employee_id',50);
            $table->string('first_name',100);
            $table->string('middle_name',100)->nullable();
            $table->string('last_name',100)->nullable();
            $table->string('alias_name',100)->nullable();
            $table->string('kode_status_ptkp',50)->nullable();
            $table->string('kode_tarif_jamsostek',50)->nullable();
            $table->date('join_date')->nullable();
            $table->date('resign_date')->nullable();
            $table->date('contract_begin_date')->nullable();
            $table->date('contract_end_date')->nullable();
            $table->string('employee_active_status',50)->nullable();
            $table->string('handphone_number',50)->nullable();
            $table->string('pkwt_number',50)->nullable();
            $table->string('email_1',100)->nullable();
            $table->string('email_2',100)->nullable();
            $table->string('bank_account_number_1',50)->nullable();
            $table->string('bank_name_1',50)->nullable();
            $table->string('bank_account_name_1',50)->nullable();
            $table->string('bank_branch_name_1',50)->nullable();
            $table->string('bank_account_number_2',50)->nullable();
            $table->string('bank_name_2',50)->nullable();
            $table->string('bank_account_name_2',50)->nullable();
            $table->string('bank_branch_name_2',50)->nullable();
            $table->string('birth_place',50)->nullable();
            $table->date('birth_date')->nullable();
            $table->string('gender',50)->nullable();
            $table->string('citizen',20)->nullable();
            $table->string('religion',50)->nullable();
            $table->string('marital_status',50)->nullable();
            $table->integer('number_of_dependents')->nullable();
            $table->integer('salary_tax_type')->nullable();
            $table->string('ptkp_status',50)->nullable();
            $table->decimal('saldo_pendapatan',13,4)->nullable();
            $table->decimal('saldo_pajak',13,4)->nullable();
            $table->integer('salary_month_begin')->nullable();
            $table->integer('salary_month_end')->nullable();
            $table->tinyInteger('overtime_status')->nullable();
            $table->string('shift_code',50)->nullable();
            $table->string('npwp_number',50)->nullable();
            $table->date('npwp_activation_date')->nullable();
            $table->tinyInteger('npwp_status')->nullable();
            $table->string('bpjs_number',50)->nullable();
            $table->date('bpjs_activation_date')->nullable();
            $table->tinyInteger('bpjs_status')->nullable();
            $table->string('pension_number',50)->nullable();
            $table->date('pension_active_date')->nullable();
            $table->tinyInteger('pension_status')->nullable();
            $table->text('address_1')->nullable();
            $table->string('sub_district_1',100)->nullable();
            $table->string('district_1',100)->nullable();
            $table->string('city_1',100)->nullable();
            $table->string('province_1',100)->nullable();
            $table->string('country_1',100)->nullable();
            $table->string('phone_number_1',20)->nullable();
            $table->string('postal_code_1',10)->nullable();
            $table->text('address_2')->nullable();
            $table->string('sub_district_2',100)->nullable();
            $table->string('district_2',100)->nullable();
            $table->string('city_2',100)->nullable();
            $table->string('province_2',100)->nullable();
            $table->string('country_2',100)->nullable();
            $table->string('phone_number_2',20)->nullable();
            $table->string('postal_code_2',10)->nullable();
            $table->string('ktp_number',50)->nullable();
            $table->date('ktp_validity_period')->nullable();
            $table->string('sim_a_number',50)->nullable();
            $table->date('sim_a_validity_period')->nullable();
            $table->string('sim_c_number',50)->nullable();
            $table->date('sim_c_validity_period')->nullable();
            $table->string('father_name',100)->nullable();
            $table->string('mother_name',100)->nullable();
            $table->string('blood_type',50)->nullable();
            $table->string('eployee_photo_file',100)->nullable();
            $table->tinyInteger('leave_status')->nullable();
            $table->decimal('remaining_day_off_1',5,2)->nullable();
            $table->decimal('remaining_day_off_2',5,2)->nullable();
            $table->integer('new_employee_id')->nullable();
            $table->string('resign_reason')->nullable();
            $table->string('fingerprint_id',50)->nullable();
            $table->string('first_employee_id',50)->nullable();
            $table->integer('contract_counter')->nullable();
            $table->string('employee_type_code',50)->nullable();
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
        Schema::dropIfExists('pegawai');
    }
}
