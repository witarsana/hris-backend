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
            'status' => ['required','integer','digits_between:0,11','in:1,2,5'],
            'dependents' => ['required','integer','digits_between:0,11','min:1','max:3'],
            'ptkp_value' => ['required','numeric'],
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
