<?php

namespace App\Model\Tenant;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AppraisalDetailHistorical extends Model
{
    use SoftDeletes;

    protected $connection = "tenant";
    protected $table = "appraisal_detail_historical";
    protected $primaryKey = "id";
    
    protected $fillable =[
        "appraisal_detail_code",
        "appraisal_code",
        "point",
        "user_input",
        "user_edit"
    ];

    
    public function user_i() {
        return $this->belongsTo('App\Model\Tenant\User', 'user_input', 'id');
    }

    public function user_e() {
        return $this->belongsTo('App\Model\Tenant\User', 'user_edit', 'id');
    }

    public function appraisal_master() {
        return $this->belongsTo('App\Model\Tenant\AppraisalMasterDetail', 'appraisal_detail_code', 'appraisal_detail_code');
    }

    public function appraisal_header() {
        return $this->belongsTo('App\Model\Tenant\AppraisalHeaderHistorical', 'appraisal_code', 'appraisal_code');
    }

}
