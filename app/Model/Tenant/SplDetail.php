<?php

namespace App\Model\Tenant;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SplDetail extends Model
{
    use SoftDeletes;
    protected $connection = "tenant";
    protected $table = "spl_detail";

    public function pegawai(){
        return $this->belongsTo("App\Model\Tenant\Pegawai","employee_id","employee_id");
    }

    public function user_i(){
        return $this->belongsTo("App\Model\Tenant\User","user_input","id");
    }

    public function user_e(){
        return $this->belongsTo("App\Model\Tenant\User","user_edit","id");
    }

    public function spl_header(){
        return $this->belongsTo("App\Model\tenant\SplHeader","spl_number","spl_number");
    }
}
