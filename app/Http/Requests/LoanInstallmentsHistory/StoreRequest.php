<?php

namespace App\Http\Requests\LoanInstallmentsHistory;

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
            "loan_number" =>["required","exists:tenant.loan_employee,loan_number"],
            "intallments_date" =>["required","date"],
            "installments_amount" =>["required","numeric"],
            "description" => ["max:50"],  
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
