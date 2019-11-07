<?php

namespace App\Http\Requests\BpjsRate;

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
            'description' => ['required'],
            'jhtp' => ['required','numeric'],
            'jhtk' => ['required','numeric'],
            'jk' => ['required','numeric'],
            'jkk' => ['required','numeric'],
            'jpk_lajang' => ['required','numeric'],
            'jpk_nikah' => ['required','numeric'],
            'bpjsp' => ['required','numeric'],
            'bpjsk' => ['required','numeric'],
            'max_salary_pension' => ['required','numeric'],
            'max_salary_medical' => ['required','numeric'],
            'pension_company' => ['required','numeric'],
            'pension_employees' => ['required','numeric'],
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
