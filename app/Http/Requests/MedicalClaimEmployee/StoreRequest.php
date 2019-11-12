<?php

namespace App\Http\Requests\MedicalClaimEmployee;

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
            "claim_date" =>["required","date"],
            "approval_date" => ["date"],
            "approval_by" => ["max:50","exists:tenant.pegawai,employee_id"],
            "claim_type" => ["required","in:medical,maternity,glasses"],
            "claim_purpose" => ["required","max:50"],
            "clinic_name" => ["required","max:50"],
            "description" => ["required"],
            "approval_status" => ["in:approved,rejected"],
            "total_claim_amount" => ["required","numeric"],
            "total_claim_approved" => ["numeric"]
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
