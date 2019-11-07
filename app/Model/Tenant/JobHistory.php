<?php

namespace App\Model\Tenant;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class JobHistory extends Model
{
    use SoftDeletes;
    protected $connection = "tenant";
    protected $table = "job_history";

    protected $fillable = [
        "employee_id",
        "company_name",
        "business_fields",
        "departement",
        "position",
        "from_date",
        "until_date",
        "description",
        "job_desc",
        "duration_of_position",
    ];

    
}
