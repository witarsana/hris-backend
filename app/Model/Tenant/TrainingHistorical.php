<?php

namespace App\Model\Tenant;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TrainingHistorical extends Model
{
    use SoftDeletes;
    
    protected $connection="tenant";
    protected $table = "training_historical";

    protected $fillable = [
        "employee_id",
        "training_name",
        "organizer",
        "trainer_name",
        "instructor",
        "certification_type",
        "start_date",
        "end_date",
        "pre_test_score",
        "post_test_score",
        "standard_score",
        "evaluation",
        "description",
        "certificate_number",
        "training_type_code",
        "user_input",
        "user_edit",
    ];

    public function  training_type(){
        return $this->belongsTo('App\Model\Tenant\MasterTrainingType', 'training_type_code', 'id');
    }

    public function  pegawai(){
        return $this->belongsTo('App\Model\Tenant\Pegawai', 'employee_id', 'employee_id');
    }

    public function user_input() {
        return $this->belongsTo('App\Model\Tenant\User', 'user_input', 'id');
    }

    public function user_edit() {
        return $this->belongsTo('App\Model\Tenant\User', 'user_edit', 'id');
    }
}
