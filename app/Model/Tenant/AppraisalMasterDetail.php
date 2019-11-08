<?php

namespace App\Model\Tenant;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class AppraisalMasterDetail extends Model
{
    use SoftDeletes;
    protected $connection = "tenant";
    protected $table ="appraisal_master_detail";
    protected $primaryKey = "appraisal_detail_code";
    public $keyType = "string";
    public function user_i(){
        return $this->belongsTo('App\Model\Tenant\User', 'user_input', 'id');
    }

    public function user_e(){
        return $this->belongsTo('App\Model\Tenant\User', 'user_edit', 'id');
    }
}
