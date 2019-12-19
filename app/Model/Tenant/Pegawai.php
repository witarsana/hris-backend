<?php

namespace App\Model\Tenant;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pegawai extends Model
{
    use SoftDeletes;
    protected $connection = 'tenant';
    protected $table = "pegawai";
    protected $primaryKey = "employee_id";
    public $keyType = "string";
    protected $fillable = [
        'employee_id',
        'first_name',
        'middle_name',
        'last_name',
        'alias_name',
        'kode_status_ptkp',
        'kode_tarif_jamsostek',
        'join_date',
        'resign_date',
        'contract_begin_date',
        'contract_end_date',
        'employee_active_status',
        'handphone_number',
        'pkwt_number',
        'email_1',
        'email_2',
        'bank_account_number_1',
        'bank_name_1',
        'bank_account_name_1',
        'bank_branch_name_1',
        'bank_account_number_2',
        'bank_name_2',
        'bank_account_name_2',
        'bank_branch_name_2',
        'birth_place',
        'birth_date',
        'gender',
        'citizen',
        'religion',
        'marital_status',
        'number_of_dependents',
        'salary_tax_type',
        'ptkp_status',
        'saldo_pendapatan',
        'saldo_pajak',
        'salary_month_begin',
        'salary_month_end',
        'overtime_status',
        'shift_status',
        'npwp_number',
        'npwp_activation_date',
        'npwp_status',
        'bpjs_number',
        'bpjs_activation_date',
        'bpjs_status',
        'pension_number',
        'pension_active_date',
        'pension_status',
        'address_1',
        'sub_district_1',
        'district_1',
        'city_1',
        'province_1',
        'country_1',
        'phone_number_1',
        'postal_code_1',
        'address_2',
        'sub_district_2',
        'district_2',
        'city_2',
        'province_2',
        'country_2',
        'phone_number_2',
        'postal_code_2',
        'ktp_number',
        'ktp_validity_period',
        'sim_a_number',
        'sim_a_validity_period',
        'sim_c_number',
        'sim_c_validity_period',
        'father_name',
        'mother_name',
        'blood_type',
        'eployee_photo_file',
        'leave_status',
        'remaining_day_off_1',
        'remaining_day_off_2',
        'new_employee_id',
        'resign_reason',
        'fingerprint_id',
        'first_employee_id',
        'contract_counter',
        'employee_type_code'
    ];


    public function get_ptkp_status(){
        return $this->belongsTo('App\Model\Tenant\PtkpStatus', 'kode_status_ptkp', 'ptkp_code');
    }

    public function get_bpjs_rate(){
        return $this->belongsTo('App\Model\Tenant\BpjsRate', 'kode_tarif_jamsostek', 'code');
    }

    public function get_education(){
        return $this->hasMany('App\Model\Tenant\Education', 'employee_id', 'employee_id');
    }

    public function get_family(){
        return $this->hasMany('App\Model\Tenant\Family', 'employee_id', 'employee_id');
    }

    public function get_job_history(){
        return $this->hasMany('App\Model\Tenant\JobHistory', 'employee_id', 'employee_id');
    }

    public function get_position_history(){
        return $this->hasMany('App\Model\Tenant\PositionHistory', 'employee_id', 'employee_id');
    }

    public function get_historical_training(){
        return $this->hasMany('App\Model\Tenant\TrainingHistorical', 'employee_id', 'employee_id');
    }

    public function get_historical_salary(){
        return $this->hasMany('App\Model\Tenant\SalaryHistorical', 'employee_id', 'employee_id');
    }

    public function get_historical_leaves(){
        return $this->hasMany('App\Model\Tenant\LeaveHistorical', 'employee_id', 'employee_id');
    }

    public function get_sanction_historical(){
        return $this->hasMany('App\Model\Tenant\SanctionHistorical', 'employee_id', 'employee_id');
    }

    public function get_employee_type(){
        return $this->belongsTo('App\Model\Tenant\EmployeeType','employee_type_code','employee_type_code');
    }

}
