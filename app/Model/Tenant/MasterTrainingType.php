<?php

namespace App\Model\Tenant;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MasterTrainingType extends Model
{
    use SoftDeletes;

    protected $connection="tenant";
    protected $table = "master_training_types";
    protected $fillable = [
        "training_type_code",
        "training_type_name",
        "user_input",
        "user_edit",       
    ];
    
    public function user_input() {
        return $this->belongsTo('App\Model\Tenant\User', 'user_input', 'id');
    }

    public function user_edit() {
        return $this->belongsTo('App\Model\Tenant\User', 'user_edit', 'id');
    }

}
