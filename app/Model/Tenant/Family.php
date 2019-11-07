<?php

namespace App\Model\Tenant;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Family extends Model
{
    use SoftDeletes;

    protected $connection = "tenant";
    protected $table = "family";

    protected $fillable = [
        "employee_id",
        "family_name",
        "birth_place",
        "birth_date",
        "gender",
        "image_file_path",
        "relation",
        "phone_number",
        "job",
        "family_number_KK",
        "bpjs_kesehatan_number",
        "child_number"
    ];

    
}
