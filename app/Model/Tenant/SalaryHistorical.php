<?php

namespace App\Model\Tenant;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SalaryHistorical extends Model
{
   use SoftDeletes;

   protected $connection = "tenant";
   protected $table ="salary_historical";
   protected $fillable = [
       "employee_id",
       "salary_code",
       "old_amount",
       "new_amount",
       "change_date",
       "active_date",
       "description",
       "user_input",
       "user_edit"
   ];
    public function  pegawai(){
        return $this->belongsTo('App\Model\Tenant\Pegawai', 'employee_id', 'employee_id');
    }

    public function user_input() {
        return $this->belongsTo('App\Model\Tenant\User', 'user_input', 'id');
    }

    public function user_edit() {
        return $this->belongsTo('App\Model\Tenant\User', 'user_edit', 'id');
    }


}
