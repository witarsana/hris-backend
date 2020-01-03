<?php

namespace App\Http\Requests\JobHistory;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreRequest extends FormRequest
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
            "employee_id" => ["required","max:50"],
            "company_name" => ["required","max:50"],
            "business_fields" => ["max:50"],
            "department" => ["max:100"],
            "position" => ["required","max:50"],
            "from_date" => ["required","date"],
            "until_date" => ["required","date"],
            "description" => ["max:50"],
            "job_desc" => ["max:50"],
            "duration_of_position" => ["max:50"],
           
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
