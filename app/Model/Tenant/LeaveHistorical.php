<?php

namespace App\Model\Tenant;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LeaveHistorical extends Model
{
    use SoftDeletes;
    
    protected $connection = "tenant";
    protected $table = "leaves_historical";
    protected $fillable = [
        "employee_id",
        "start_date",
        "end_date",
        "leave_amount_days",
        "leave_type",
        "description",
        "outside_city_status",
        "emergency_number",
        "delegation_job_to",
        "approved_by",
        "approved_date",
        "user_input",
        "user_edit",
    ];
    
    public function user_i() {
        return $this->belongsTo('App\Model\Tenant\User', 'user_input', 'id');
    }

    public function user_e() {
        return $this->belongsTo('App\Model\Tenant\User', 'user_edit', 'id');
    }

    public function  pegawai(){
        return $this->belongsTo('App\Model\Tenant\Pegawai', 'employee_id', 'employee_id');
    }

    public function  delegation(){
        return $this->belongsTo('App\Model\Tenant\Pegawai', 'delegation_job_to', 'employee_id');
    }

    public function approved(){
        return $this->belongsTo('App\Model\Tenant\Pegawai', 'approved_by', 'employee_id');
    }

}
