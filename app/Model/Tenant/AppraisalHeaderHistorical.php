<?php

namespace App\Model\Tenant;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AppraisalHeaderHistorical extends Model
{
    use SoftDeletes;
    protected $connection = "tenant";
    protected $table ="appraisal_header_historical";
    protected $primaryKey = "appraisal_code";
    public $keyType = "string";
    protected $fillable =[
        "appraisal_code",
        "employee_id",
        "total_point",
        "appraisal_month",
        "appraisal_year",
        "description",
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

    public function appraisal_detail_historical(){
        return $this->hasMany('App\Model\Tenant\AppraisalDetailHistorical','appraisal_code','appraisal_code');
    }

}
