<?php

namespace App\Http\Requests\Family;

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
            "employee_id" =>["required","max:50"],
            "family_name" =>["required","max:100"],
            "birth_place" =>["required","max:50"],
            "birth_date" =>["required","date"],
            "gender" =>["required","max:50"],
            "image_file_path" =>["mimes:jpeg,bmp,png"],
            "relation" =>["required","max:50"],
            "phone_number" =>["max:50"],
            "job" =>["max:100"],
            "family_number_KK" =>["max:50"],
            "bpjs_kesehatan_number"=>["max:50"],
            "child_number" =>["required","integer"],
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
