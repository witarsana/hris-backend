<?php

namespace App\Model\Tenant;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SalaryMasterData extends Model
{
    use SoftDeletes;
    protected $connection = "tenant";
    protected $table = "salary_master_data";
    protected $primaryKey = "salary_code"; 
    public $keyType = "string";

    public function user_i() {
        return $this->belongsTo('App\Model\Tenant\User', 'user_input', 'id');
    }

    public function user_e() {
        return $this->belongsTo('App\Model\Tenant\User', 'user_edit', 'id');
    }
}
