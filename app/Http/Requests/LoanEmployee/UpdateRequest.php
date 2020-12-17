<?php

namespace App\Http\Requests\LoanEmployee;

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
            "employee_id" =>["required","max:50","exists:tenant.pegawai,employee_id"],
            "loan_date" =>["required","date"],
            "loan_amount" =>["required","numeric"],
            "loan_interest" =>["required","numeric"],
            "installments" => ["required","numeric"],
            "total_paid" => ["numeric"],
            "loan_source" => ["max:50","in:Company,Koperasi"],
            "period" => ["required","integer"],
            "total_loan" => ["numeric"],
            "loan_status" => ["in:On Progress,Paid Off"],
            "process_date" => ["date"],
            "process_flag" => ["in:1,0"],
            "description" => ["max:50"],
            "approved_by" => ["max:50","exists:tenant.pegawai,employee_id"],
            "submitted_by" => ["max:50","exists:tenant.pegawai,employee_id"],
            "collateral" => ["max:100"],
            "interest_type" => ["required","in:Flat,Efektif"],
            "interest_of_installments" => ["numeric"],
            "remaining_loan" => ["numeric"],   
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
