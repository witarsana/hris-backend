<?php

namespace App\Http\Requests\SalaryHistorical;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Exceptions\HttpResponseException;


class UpdateRequest extends FormRequest
{
    
    public function authorize()
    {
        return true;
    }

    
    public function rules()
    {
        return [
            "employee_id" =>["required","max:50"],
            "salary_code" =>["required","max:50"],
            "old_amount" =>["required","numeric"],
            "new_amount" =>["required","numeric"],
            "change_date" =>["required","date"],
            "certification_type" =>["max:50"],
            "start_date" =>["required","date"],
            "active_date"=>["date"],
            "description" => ["required"],
           
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $errors = (new ValidationException($validator))->errors();
        
        throw new HttpResponseException(
            response()->json(
                ['success' => false,'message'=>500,'data' => $errors], JsonResponse::HTTP_UNPROCESSABLE_ENTITY)
        );
    }
}
