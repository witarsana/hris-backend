<?php

namespace App\Model\Tenant;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Education extends Model
{
    use SoftDeletes;

    protected $connection = "tenant";
    protected $table="education";

    protected $fillable = [
        "employee_id",
        "grade",
        "education_name",
        "location",
        "education_duration",
        "graduate_year",
        "description",
        "last_education_status"
    ];

    
}
