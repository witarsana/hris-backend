<?php

namespace App\Http\Requests\WorkshiftMasterData;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

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
           /* "shift_code" =>["required","max:50",Rule::unique('tenant.workshift_master_data')->ignore($this->id,'shift_code')],*/
            "shift_code" =>["required","max:50"],
            "shift_name" =>["required","max:100"],
            "begin_time" =>["required","date_format:H:i"],
            "end_time" =>["required","date_format:H:i"],    
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
