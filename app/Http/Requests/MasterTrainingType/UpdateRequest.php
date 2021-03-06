<?php

namespace App\Http\Requests\MasterTrainingType;

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
            "training_type_code" => ["required",Rule::unique('tenant.master_training_types')->ignore($this->id),"max:50"],
            "training_type_name" => ["required","max:100"],            
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
