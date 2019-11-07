<?php

namespace App\Model\Tenant;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class PositionHistory extends Model
{
    use SoftDeletes;

    protected $connection="tenant";
    protected $table = "position_history";
    protected $fillable = [
        "employee_id",
        "old_position",
        "new_position",
        "promotion_date",
        "old_position_duration",
        "description"
    ];

    
}
