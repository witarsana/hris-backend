<?php

namespace App\Http\Requests\Pegawai;

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
            //"employee_id" => ['required','unique:tenant.pegawai,employee_id,'.$this->employee_id.'','max:50'],
            "first_name"  => ['required','max:100'],
            "middle_name" => ['max:100'],
            "last_name"   => ['max:100'],
            "alias_name"  => ['max:100'],
            "kode_status_ptkp" => ['required'],
            "kode_tarif_jamsostek" => ['required'],
            "join_date" => ["required","date"],
            "resign_date"=> ["date"],
            "contract_begin_date" => ["required","date"],
            "contract_end_date" => ["required","date"],
            "employee_active_status" => ["required","max:50"],
            "handphone_number" => ["required","max:50"],
            "pkwt_number" => ["required","max:50"],
            "email_1" => ["required","email"],
            "email_2" => ["email"],
            "bank_account_number_1" => ["required","max:50"],
            "bank_name_1" => ["required","max:50"],
            "bank_account_name_1" => ["required","max:50"],
            "bank_branch_name_1" => ["required","max:50"],
            "bank_account_number_2" => ["max:50"],
            "bank_name_2" => ["max:50"],
            "bank_account_name_2" => ["max:50"],
            "bank_branch_name_2" => ["max:50"],
            "birth_place" => ["required","max:50"],
            "birth_date" => ["required","date"],
            "gender" => ["required","max:50"],
            "citizen" => ["required","max:20"],
            "religion" => ["required","max:50"],
            "marital_status" => ["required","max:50"],
            "number_of_dependents" => ["required","integer"],
            "salary_tax_type" => ["required","integer"],
            "ptkp_status" => ["required"],
            "saldo_pendapatan" => ['required','numeric'],
            "saldo_pajak" => ["required","numeric"],
            "salary_month_begin" => ["required","integer"],
            "salary_month_end" => ["required","integer"],
            "overtime_status" => ["required","integer"],
            "shift_status" => ["required","integer"],
            "npwp_number" => ["max:50"],
            "npwp_activation_date" => ["date"],
            "npwp_status" => ["integer"],
            "bpjs_number" => ["max:50"],
            "bpjs_activation_date" => ["date"],
            "bpjs_status" => ["integer"],
            "pension_number" => ["max:50"],
            "pension_active_date" => ["date"],
            "pension_status" => ["integer"],
            "address_1" => ["required"],
            "sub_district_1" => ["required","max:100"],
            "district_1" => ["required","max:100"],
            "city_1" => ["required","max:100"],
            "province_1" => ["required","max:100"],
            "country_1" => ["required","max:100"],
            "phone_number_1" => ["required","max:20"],
            "postal_code_1" => ["required","max:10"],
            "sub_district_2" => ["max:100"],
            "district_2" => ["max:100"],
            "city_2" => ["max:100"],
            "province_2" => ["max:100"],
            "country_2" => ["max:100"],
            "phone_number_2" => ["max:20"],
            "postal_code_2" => ["max:10"],
            "ktp_number" => ["required","max:50"],
            "ktp_validity_period" => ["required","date"],
            "sim_a_number" => ["max:50"],
            "sim_a_validity_period" => ["date"],
            "sim_c_number" => ["max:50"],
            "sim_c_validity_period" => ["date"],
            "father_name" => ["max:100"],
            "mother_name" => ["max:100"],
            "blood_type" => ["max:50"],
            "eployee_photo_file" => ['mimes:jpeg,bmp,png'],
            "leave_status" => ["integer"],
            "remaining_day_off_1" => ["required","numeric"],
            "remaining_day_off_2" => ["required","numeric"],
            "new_employee_id" => ["integer"],
            "resign_reason" => ["max:255"],
            "fingerprint_id" => ["max:50"],
            "first_employee_id" => ["max:50"],
            "contract_counter" => ["integer"]

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
