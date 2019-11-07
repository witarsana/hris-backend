<?php

namespace App\Http\Requests\PtkpStatus;

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
            'description' => ['required'],
            'status' => ['required','integer'],
            'dependents' => ['required','integer'],
            'ptkp_value' => ['required','integer'],
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
