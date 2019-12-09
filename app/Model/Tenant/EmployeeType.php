<?php

namespace App\Model\Tenant;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EmployeeType extends Model
{
    use SoftDeletes;
    protected $connection ="tenant";
    protected $table = "employee_type";

    public function user_i(){
        return $this->belongsTo('App\Model\Tenant\User','user_input','id');
    }

    public function user_e(){
        return $this->belongsTo('App\Model\Tenant\User','user_edit','id');
    }
}
