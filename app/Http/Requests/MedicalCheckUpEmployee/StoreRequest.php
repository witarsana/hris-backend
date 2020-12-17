<?php

namespace App\Http\Requests\MedicalCheckUpEmployee;

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

    public function rules()
    {   
        return [
            "employee_id" =>["required","max:50","exists:tenant.pegawai,employee_id"],
            "mcu_type" =>["required","in:awal,tahunan,lainnya"],
            "year" =>["required","integer","min:1900"],
            "mcu_date" =>["required","date"],
            "age" => ["integer"],
            "body_weight" => ["max:50"],
            "body_height" => ["max:50"],
            "imtbmi" => ["max:50"],
            "right_eye_visus" => ["in:normal,positif,negatif"],
            "left_eye_visus" => ["in:normal,positif,negatif"],
            "color_blind" => ["in:positif,negatif"],
            "physical" => ["max:100"],
            "pushup" => ["max:100"],
            "blood_presure1" => ["max:50"],
            "blood_pressure2" => ["max:50"],
            "respiratory_1" => ["max:50"],
            "respiratory_2" => ["max:50"],
            "urine_lab" => ["in:normal,abnormal"],
            "blood_lab" => ["in:normal,abnormal"],
            "hbsag" => ["in:reaktif,non reaktif"],
            "radiology" => ["in:normal,abnormal"],
            "audiometry" => ["max:50"],
            "blood_type" => ["in:a,b,ab,o"],
            "rhesus" => ["in:positif,negatif"],
            "ekg" => ["in:normal,abnormal,none"],
            "teeth" => ["in:normal,abnormal"]

            
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
