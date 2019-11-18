<?php

namespace App\Model\Tenant;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LoanInstallmentsHistory extends Model
{
    use SoftDeletes;

    protected $connection = "tenant";
    protected $table = "loan_installments_history";

    public function pegawai(){
        return $this->belongsTo("App\Model\Tenant\Pegawai","employee_id","employee_id");
    }

    public function user_i(){
        return $this->belongsto("App\Model\Tenant\User","user_input","id");
    }

    public function user_e(){
        return $this->belongsto("App\Model\Tenant\User","user_edit","id");
    }

    //public function loan_master(){
        //return $this->belongsto("App\Model\Tenant\LoanEmployee","loan_number","loan_number");
    //}
}
