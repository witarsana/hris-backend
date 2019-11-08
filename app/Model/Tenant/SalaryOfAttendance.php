<?php

namespace App\Model\Tenant;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SalaryOfAttendance extends Model
{
    use SoftDeletes;
    protected $connection = "tenant";
    protected $table ="salary_of_attendance";

    public function pegawai(){
        return $this->belongsTo("App\Model\Tenant\Pegawai","employee_id","employee_id");
    }

    public function user_i(){
        return $this->belongsTo("App\Model\Tenant\User","user_input","id");
    }

    public function user_e(){
        return $this->belongsTo("App\Model\Tenant\User","user_edit","id");
    }

    public function salary(){
        return $this->belongsTo("App\Model\Tenant\SalaryMasterData","salary_code","salary_code");
    }
}
