<?php

namespace App\Http\Requests\LeaveHistorical;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "employee_id" =>["required","max:50"],
            "start_date" =>["required","date"],
            "end_date" =>["required","date"],
            "leave_amount_days" =>["required","integer"],
            "leave_amount_days" =>["required","integer"],
            "leave_type" =>["required","max:50"],
            "description" =>["required","max:50"],
            "outside_city_status" =>["integer"],
            "emergency_number"=>["required","max:50"],
            "descridelegation_job_toption" => ["max:50"],
            "approved_by" => ["max:50"],
            "approved_date" => ["date"],
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
