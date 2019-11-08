<?php

namespace App\Model\Tenant;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class EmployeeOrganization extends Model
{
    use SoftDeletes;

    protected $connection = "tenant";
    protected $table = "employee_organization";
    
    public function pegawai(){
        return $this->belongsTo("App\Model\Tenant\Pegawai","employee_id","employee_id");
    }

    public function organization(){
        return $this->belongsTo("App\Model\Tenant\OrganizationMasterData","org_code","org_code");
    }

    public function user_i(){
        return $this->belongsTo("App\Model\Tenant\User","user_input","id");
    }

    public function user_e(){
        return $this->belongsTo("App\Model\Tenant\User","user_edit","id");
    }
}
