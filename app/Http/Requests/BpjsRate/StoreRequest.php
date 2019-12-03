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
            'jhtp' => ['required','numeric','max:99999','regex:/^\d*(\.\d{1,2})?$/'],
            'jhtk' => ['required','numeric','max:99999','regex:/^\d*(\.\d{1,2})?$/'],
            'jk' => ['required','numeric','max:99999','regex:/^\d*(\.\d{1,2})?$/'],
            'jkk' => ['required','numeric','max:99999','regex:/^\d*(\.\d{1,2})?$/'],
            'jpk_lajang' => ['required','numeric','max:99999','regex:/^\d*(\.\d{1,2})?$/'],
            'jpk_nikah' => ['required','numeric','max:99999','regex:/^\d*(\.\d{1,2})?$/'],
            'bpjsp' => ['required','numeric','max:99999','regex:/^\d*(\.\d{1,2})?$/'],
            'bpjsk' => ['required','numeric','max:99999','regex:/^\d*(\.\d{1,2})?$/'],
            'max_salary_pension' => ['required','numeric','regex:/^\d*(\.\d{1,4})?$/'],
            'max_salary_medical' => ['required','numeric','regex:/^\d*(\.\d{1,4})?$/'],
            'pension_company' => ['required','numeric','max:99999','regex:/^\d*(\.\d{1,2})?$/'],
            'pension_employees' => ['required','numeric','max:99999','regex:/^\d*(\.\d{1,2})?$/'],
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
