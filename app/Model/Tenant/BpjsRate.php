<?php

namespace App\Model\Tenant;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BpjsRate extends Model{
    use SoftDeletes;

    protected $connection = 'tenant';
    protected $table = "bpjs_rates";
    protected $primaryKey = 'code';
    public $keyType = "string";
    protected $fillable = [
        "code",
        "description",
        "jhtp",
        "jhtk",
        "jk",
        "jkk",
        "jpk_lajang",
        "jpk_nikah",
        "bpjsp",
        "bpjsk",
        "max_salary_pension",
        "max_salary_medical",
        "pension_company",
        "pension_employees"
    ];

    
}
