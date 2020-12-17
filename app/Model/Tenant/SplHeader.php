<?php

namespace App\Model\Tenant;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SplHeader extends Model
{
    use SoftDeletes;
    protected $connection = "tenant";
    protected $table = "spl_header";
    protected $primaryKey = "spl_number";
    public $keyType = "string";

    public function user_i(){
        return $this->belongsTo("App\Model\Tenant\User","user_input","id");
    }

    public function user_e(){
        return $this->belongsTo("App\Model\Tenant\User","user_edit","id");
    }

    public function spl_detail(){
        return $this->hasMany("App\Model\Tenant\SplDetail","spl_number","spl_number");
    }
}
