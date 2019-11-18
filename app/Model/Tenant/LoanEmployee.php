<?php

namespace App\Model\Tenant;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LoanEmployee extends Model
{
    use SoftDeletes;
    
    protected $connection = "tenant";
    protected $table ="loan_employee";
    protected $primaryKey = "loan_number"; 
    public $keyType = "string"; 

    public function pegawai(){
        return $this->belongsTo("App\Model\Tenant\Pegawai","employee_id","employee_id");
    }

    public function user_i(){
        return $this->belongsto("App\Model\Tenant\User","user_input","id");
    }

    public function user_e(){
        return $this->belongsto("App\Model\Tenant\User","user_edit","id");
    }

    public function approved(){
        return $this->belongsTo("App\Model\Tenant\Pegawai","approved_by","employee_id");
    }

    public function submited(){
        return $this->belongsTo("App\Model\Tenant\Pegawai","submitted_by","employee_id");
    }
}
