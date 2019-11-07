<?php

namespace App\Model\Tenant;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PtkpStatus extends Model{
    use SoftDeletes;

    protected $connection = 'tenant';
    protected $table = "ptkp_status";
    protected $primaryKey = 'ptkp_code';
    public $keyType = "string";
    protected $fillable = [
        "ptkp_code",
        "description",
        "status",
        "dependents",
        "ptkp_value"
    ];

    

}
