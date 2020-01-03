<?php

namespace App\Model\Tenant;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrganizationMasterData extends Model
{
    use SoftDeletes;

    protected $connection = "tenant";
    protected $table = "organization_master_data";
    protected $primaryKey = "org_code";
    public $keyType = "string";

    public function childone()
    {
        return $this->hasMany(self::class,"dependent_to","org_code")
                    ->orderBy('sorting_number', 'ASC');
    }

    public function children()
    {
        return $this->childone()->with('org_level:org_level_code,org_level_name','children','user_i:id,name','user_e:id,name',);       
    }

    public function user_i() {
        return $this->belongsTo('App\Model\Tenant\User', 'user_input', 'id');
    }

    public function user_e() {
        return $this->belongsTo('App\Model\Tenant\User', 'user_edit', 'id');
    }

    public function org_level() {
        return $this->belongsTo('App\Model\Tenant\OrganizationLevel', 'org_level_code', 'org_level_code');
    }
}
