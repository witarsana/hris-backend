<?php

namespace App\Http\Requests\TrainingHistorical;

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
            "training_name" =>["required","max:100"],
            "organizer" =>["required","max:100"],
            "trainer_name" =>["max:100"],
            "instructor" =>["max:100"],
            "certification_type" =>["max:50"],
            "start_date" =>["required","date"],
            "end_date"=>["required","date"],
            "pre_test_score" => ["max:50"],
            "post_test_score" => ["max:50"],
            "standard_score"=> ["max:50"],
            "evaluation" => ["max:255"],
            "description",
            "certificate_number" => ["max:255"],
            "training_type_code" => ["required","integer"],
            
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
