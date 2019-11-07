<?php

namespace App\Http\Requests\SalaryMasterData;

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
            "salary_code" => ["required","max:50","unique:tenant.salary_master_data"],
            "salary_name" => ["required","max:100"],            
            "income_deduction_status" => ["required","in:income,deduction"],
            "active_status" => ["required","in:active,not active"],
            "regular_iregular_status" => ["required","in:regular,iregular"],
            "attendance_related_status" => ["required","in:related,non related"],
            "thr_related_status" => ["required","in:related,not related"],
            "overtime_related_status" => ["required","in:related,not related"],
            "tax_related_status" => ["required","in:related,not related"],
            "bpjstk_related_status" => ["required","in:related,not related"],
            "bpjskes_related_status" => ["required","in:related,not related"],
            "description" => ["max:100"], 
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
