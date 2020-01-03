<?php

namespace App\Model\Tenant;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrganizationLevel extends Model{
    use SoftDeletes;

    protected $connection = 'tenant';
    protected $table = "organization_level";
    protected $primaryKey = 'org_level_code';
    public $keyType = "string";
    protected $fillable = [
        "org_level_code",
        "org_level_name",
        "org_level_desc",
        "sorting_number"
    ];

    

}
