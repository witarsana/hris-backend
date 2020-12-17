<?php

namespace App\Model\Tenant;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MedicalClaimEmployee extends Model
{
    use SoftDeletes;

    protected $connection = "tenant";
    protected $table = "medical_claim_employee";

    public function pegawai(){
        return $this->belongsTo("App\Model\Tenant\Pegawai","employee_id","employee_id");
    }

    public function approval(){
        return $this->belongsTo("App\Model\Tenant\Pegawai","approval_by","employee_id");
    }

    public function user_i(){
        return $this->belongsTo("App\Model\Tenant\User","user_input","id");
    }

    public function user_e(){
        return $this->belongsTo("App\Model\Tenant\User","user_edit","id");
    }
}
