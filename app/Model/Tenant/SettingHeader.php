<?php

namespace App\Model\Tenant;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SettingHeader extends Model
{
    use SoftDeletes;

    protected $connection = "tenant";
    protected $table = "setting_header";

    public function details(){
        return $this->hasMany("App\Model\Tenant\SettingDetail","modul_id","id");
    }
}
