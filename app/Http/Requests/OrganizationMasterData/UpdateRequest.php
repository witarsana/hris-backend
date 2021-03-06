<?php

namespace App\Http\Requests\OrganizationMasterData;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class UpdateRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

   
    public function rules()
    {
        
        return [           
            //"org_code" => ["required",Rule::unique('tenant.organization_master_data')->ignore($this->org_code),"max:50"],
            "org_name" => ["required","max:100"],
            "dependent_to" => ["max:50"],
            "org_level_code" => ["required","max:50"],
            "dependent_status" => ["required","in:dependant,not dependant"],
            "mandatory_status" => ["required","in:mandatory,not mandatory"],
            "user_management_status" => ["required","in:related,not related"],
            "sorting_number" => ["required","integer"],
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $errors = (new ValidationException($validator))->errors();
        
        throw new HttpResponseException(
            response()->json(
                ['success' => false,'message'=>500,'data' => $errors], JsonResponse::HTTP_ACCEPTED)
        );
    }
}
