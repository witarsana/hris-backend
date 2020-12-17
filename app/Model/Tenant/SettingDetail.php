<?php

namespace App\Model\Tenant;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SettingDetail extends Model
{
    use SoftDeletes;

    protected $connection = "tenant";
    protected $table = "setting_detail";

    public function modul(){
        return $this->belongsTo("App\Model\Tenant\SettingHeader","modul_id","id");
    }
}
