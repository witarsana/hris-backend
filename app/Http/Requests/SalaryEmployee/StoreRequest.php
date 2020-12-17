<?php

namespace App\Http\Requests\SalaryEmployee;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    
    public function rules()
    {
        return [
            "employee_id" =>["required","max:50","exists:tenant.pegawai,employee_id"],
            "salary_code" =>["required","max:50","exists:tenant.salary_master_data,salary_code"],
            "amount" =>["required","numeric"],          
            "description" =>["required"],           
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
