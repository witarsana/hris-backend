<?php

namespace App\Model\Main;

use Laravel\Passport\HasApiTokens;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Hash;

class Company extends Authenticatable{

    use HasApiTokens, Notifiable,SoftDeletes;
    
    protected $table = "companies";
    protected $primaryKey = 'id_number';
    protected $fillable = [
        'company_id', 
        'company_name', 
        'company_email',
        'company_password',
        'db_host',
        'db_port',
        'db_user',
        'db_password',
        'user_input',
        'user_edit',
        'user_delete',
    ];
    protected $hidden = [
        'company_password', 
        'db_password',
    ];

    public function findForPassport($username){
        return $this->where('company_name', $username)->first();
    }

    
    public function validateForPassportPasswordGrant($password)
    {
        return Hash::check($password, $this->company_password);
    }

}
