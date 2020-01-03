<?php

namespace App\Http\Requests\Attendance;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreRequest extends FormRequest
{
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
            "date" =>["required","date"],
            "time_in" =>["required","date_format:H:i"],
            "time_out" =>["required","date_format:H:i","after:time_in"],
            "shift_code" =>["required","max:50"],
            "total_work_hour" =>["required","date_format:H:i"],
            "day_type" =>["required","in:workday,holiday"],
            "overtime_value_by_SPL" =>["numeric"],
            "overtime_value_by_att" =>["numeric"],
            "overtime_value_by_approval" =>["numeric"],
            "overtime_value_conversion" =>["numeric"],
            "late_status" =>["required","in:normal,late"],
            "late_minutes" =>["required","date_format:H:i"],
            "early_out_status" =>["required","in:normal,early"],
            "early_out_minutes" =>["required","date_format:H:i"]     
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
