<?php

namespace App\Http\Controllers\Api;

use App\Model\Tenant\Pegawai;
use App\Model\Tenant\EmployeeOrganization;
use App\Model\Tenant\SalaryEmployee;
use App\Model\Main\Company;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Pegawai\StoreRequest;
use App\Http\Requests\Pegawai\UpdateRequest;
use Ramsey\Uuid\Uuid;
use File;
use Validator;
use Illuminate\Http\JsonResponse;

class PegawaiController extends Controller
{
  
    public function index()
    {    
         
        try{
            $lsPegawai = Pegawai::with('get_ptkp_status','get_bpjs_rate','get_employee_type')->get();
            
            return $this->sendResponse($lsPegawai, $this->successStatus);
        }catch (\Exception $e){
            return $this->sendError(500, ['error'=> $e]);
        }
        
    }

    public function listFilterAndPagine(Request $request){
        
        $filter = $request->filter;
        $count = $request->count;
        try{
            if (strlen($filter)>0){
                $lsPegawai = Pegawai::with('get_ptkp_status','get_bpjs_rate','get_employee_type')
                            ->where('employee_id', 'like', '%' . $filter . '%')
                            ->orWhere('first_name', 'like', '%' . $filter . '%')
                            ->orWhere('middle_name', 'like', '%' . $filter . '%')
                            ->orWhere('last_name', 'like', '%' . $filter . '%')
                            ->orWhere('alias_name', 'like', '%' . $filter . '%')
                            ->orWhere('kode_status_ptkp', 'like', '%' . $filter . '%')
                            ->orWhere('kode_tarif_jamsostek', 'like', '%' . $filter . '%')
                            ->orWhere('join_date', 'like', '%' . $filter . '%')
                            ->orWhere('resign_date', 'like', '%' . $filter . '%')
                            ->orWhere('contract_begin_date', 'like', '%' . $filter . '%')
                            ->orWhere('contract_end_date', 'like', '%' . $filter . '%')
                            ->orWhere('employee_active_status', 'like', '%' . $filter . '%')
                            ->orWhere('handphone_number', 'like', '%' . $filter . '%')
                            ->orWhere('pkwt_number', 'like', '%' . $filter . '%')
                            ->orWhere('email_1', 'like', '%' . $filter . '%')
                            ->orWhere('email_2', 'like', '%' . $filter . '%')
                            ->orWhere('bank_account_number_1', 'like', '%' . $filter . '%')
                            ->orWhere('bank_name_1', 'like', '%' . $filter . '%')
                            ->orWhere('bank_account_name_1', 'like', '%' . $filter . '%')
                            ->orWhere('bank_branch_name_1', 'like', '%' . $filter . '%')
                            ->orWhere('bank_account_number_2', 'like', '%' . $filter . '%')
                            ->orWhere('bank_name_2', 'like', '%' . $filter . '%')
                            ->orWhere('bank_account_name_2', 'like', '%' . $filter . '%')
                            ->orWhere('bank_branch_name_2', 'like', '%' . $filter . '%')
                            ->orWhere('birth_place', 'like', '%' . $filter . '%')
                            ->orWhere('birth_date', 'like', '%' . $filter . '%')
                            ->orWhere('gender', 'like', '%' . $filter . '%')
                            ->orWhere('citizen', 'like', '%' . $filter . '%')
                            ->orWhere('religion', 'like', '%' . $filter . '%')
                            ->orWhere('marital_status', 'like', '%' . $filter . '%')
                            ->orWhere('number_of_dependents', 'like', '%' . $filter . '%')
                            ->orWhere('salary_tax_type', 'like', '%' . $filter . '%')
                            ->orWhere('ptkp_status', 'like', '%' . $filter . '%')
                            ->orWhere('saldo_pendapatan', 'like', '%' . $filter . '%')
                            ->orWhere('saldo_pajak', 'like', '%' . $filter . '%')
                            ->orWhere('salary_month_begin', 'like', '%' . $filter . '%')
                            ->orWhere('salary_month_end', 'like', '%' . $filter . '%')
                            ->orWhere('overtime_status', 'like', '%' . $filter . '%')
                            ->orWhere('shift_code', 'like', '%' . $filter . '%')
                            ->orWhere('npwp_number', 'like', '%' . $filter . '%')
                            ->orWhere('npwp_activation_date', 'like', '%' . $filter . '%')
                            ->orWhere('npwp_status', 'like', '%' . $filter . '%')
                            ->orWhere('bpjs_number', 'like', '%' . $filter . '%')
                            ->orWhere('bpjs_activation_date', 'like', '%' . $filter . '%')
                            ->orWhere('bpjs_status', 'like', '%' . $filter . '%')
                            ->orWhere('pension_number', 'like', '%' . $filter . '%')
                            ->orWhere('pension_active_date', 'like', '%' . $filter . '%')
                            ->orWhere('pension_status', 'like', '%' . $filter . '%')
                            ->orWhere('address_1', 'like', '%' . $filter . '%')
                            ->orWhere('sub_district_1', 'like', '%' . $filter . '%')
                            ->orWhere('district_1', 'like', '%' . $filter . '%')
                            ->orWhere('city_1', 'like', '%' . $filter . '%')
                            ->orWhere('province_1', 'like', '%' . $filter . '%')
                            ->orWhere('country_1', 'like', '%' . $filter . '%')
                            ->orWhere('phone_number_1', 'like', '%' . $filter . '%')
                            ->orWhere('postal_code_1', 'like', '%' . $filter . '%')
                            ->orWhere('address_2', 'like', '%' . $filter . '%')
                            ->orWhere('sub_district_2', 'like', '%' . $filter . '%')
                            ->orWhere('district_2', 'like', '%' . $filter . '%')
                            ->orWhere('city_2', 'like', '%' . $filter . '%')
                            ->orWhere('province_2', 'like', '%' . $filter . '%')
                            ->orWhere('country_2', 'like', '%' . $filter . '%')
                            ->orWhere('phone_number_2', 'like', '%' . $filter . '%')
                            ->orWhere('postal_code_2', 'like', '%' . $filter . '%')
                            ->orWhere('ktp_number', 'like', '%' . $filter . '%')
                            ->orWhere('ktp_validity_period', 'like', '%' . $filter . '%')
                            ->orWhere('sim_a_number', 'like', '%' . $filter . '%')
                            ->orWhere('sim_a_validity_period', 'like', '%' . $filter . '%')
                            ->orWhere('sim_c_number', 'like', '%' . $filter . '%')
                            ->orWhere('sim_c_validity_period', 'like', '%' . $filter . '%')
                            ->orWhere('father_name', 'like', '%' . $filter . '%')
                            ->orWhere('mother_name', 'like', '%' . $filter . '%')
                            ->orWhere('blood_type', 'like', '%' . $filter . '%')
                            ->orWhere('eployee_photo_file', 'like', '%' . $filter . '%')
                            ->orWhere('leave_status', 'like', '%' . $filter . '%')
                            ->orWhere('remaining_day_off_1', 'like', '%' . $filter . '%')
                            ->orWhere('remaining_day_off_2', 'like', '%' . $filter . '%')
                            ->orWhere('new_employee_id', 'like', '%' . $filter . '%')
                            ->orWhere('resign_reason', 'like', '%' . $filter . '%')
                            ->orWhere('fingerprint_id', 'like', '%' . $filter . '%')
                            ->orWhere('first_employee_id', 'like', '%' . $filter . '%')
                            ->orWhere('contract_counter', 'like', '%' . $filter . '%')

                            ->paginate($count);
            }else{
                $lsPegawai = Pegawai::with('get_ptkp_status','get_bpjs_rate','get_employee_type')->paginate($count);
            }
            
            
            return $this->sendResponse($lsPegawai, $this->successStatus);
        }catch (\Exception $e){
            return $this->sendError(500, ['error'=> $e]);
        }
    }

    public function store(StoreRequest $request)
    {   
        try {
            //find the company name, so it can store image on the right directory
            //list($companyName) = explode('.', $request->getHost(), 2);
            $companyName = $request->user()->company_name;
            $company = Company::where("company_name",$companyName)->first();

            //files            
            $path = "";
            $fileName ="";
            
            if ($request->hasFile('eployee_photo_file')) {
                //if image valid then store here
                //check folder for the company already created or not
                if (! File::exists(public_path()."/".$company->company_name."")) {
                    // if not then make new folder            
                    File::makeDirectory(public_path()."/".$company->company_name."",$mode = 0777, true, true);
                }
                //upload the file
                $fileName = Uuid::uuid4()->getHex().".jpg";
                $path = $request->file('eployee_photo_file')->move(public_path('/'.$company->company_name.'/'),$fileName);               
            }

            //save pegawai 
            $oPegawai = new Pegawai();
            $oPegawai->employee_id= $request->employee_id;
            
            $oPegawai->first_name= $request->first_name;
            $oPegawai->middle_name= $request->middle_name;
            $oPegawai->last_name= $request->last_name;
            $oPegawai->alias_name= $request->alias_name;
            $oPegawai->kode_status_ptkp= $request->kode_status_ptkp;
            $oPegawai->kode_tarif_jamsostek= $request->kode_tarif_jamsostek;
            $oPegawai->join_date= $request->join_date;
            $oPegawai->resign_date= $request->resign_date;
            $oPegawai->contract_begin_date= $request->contract_begin_date;
            $oPegawai->contract_end_date= $request->contract_end_date;
            $oPegawai->employee_active_status= $request->employee_active_status;
            $oPegawai->handphone_number= $request->handphone_number;
            $oPegawai->pkwt_number= $request->pkwt_number;
            $oPegawai->email_1= $request->email_1;
            $oPegawai->email_2= $request->email_2;
            $oPegawai->bank_account_number_1= $request->bank_account_number_1;
            $oPegawai->bank_name_1= $request->bank_name_1;
            $oPegawai->bank_account_name_1= $request->bank_account_name_1;
            $oPegawai->bank_branch_name_1= $request->bank_branch_name_1;
            $oPegawai->bank_account_number_2= $request->bank_account_number_2;
            $oPegawai->bank_name_2= $request->bank_name_2;
            $oPegawai->bank_account_name_2= $request->bank_account_name_2;
            $oPegawai->bank_branch_name_2= $request->bank_branch_name_2;
            $oPegawai->birth_place= $request->birth_place;
            $oPegawai->birth_date= $request->birth_date;
            $oPegawai->gender= $request->gender;
            $oPegawai->citizen= $request->citizen;
            $oPegawai->religion= $request->religion;
            $oPegawai->marital_status= $request->marital_status;
            $oPegawai->number_of_dependents= $request->number_of_dependents;
            $oPegawai->salary_tax_type= $request->salary_tax_type;
            $oPegawai->ptkp_status= $request->ptkp_status;
            $oPegawai->saldo_pendapatan= $request->saldo_pendapatan;
            $oPegawai->saldo_pajak= $request->saldo_pajak;
            $oPegawai->salary_month_begin= $request->salary_month_begin;
            $oPegawai->salary_month_end= $request->salary_month_end;
            $oPegawai->overtime_status= $request->overtime_status;
            $oPegawai->shift_code= $request->shift_code;
            $oPegawai->npwp_number= $request->npwp_number;
            $oPegawai->npwp_activation_date= $request->npwp_activation_date;
            $oPegawai->npwp_status= $request->npwp_status;
            $oPegawai->bpjs_number= $request->bpjs_number;
            $oPegawai->bpjs_activation_date= $request->bpjs_activation_date;
            $oPegawai->bpjs_status= $request->bpjs_status;
            $oPegawai->pension_number= $request->pension_number;
            $oPegawai->pension_active_date= $request->pension_active_date;
            $oPegawai->pension_status= $request->pension_status;
            $oPegawai->address_1= $request->address_1;
            $oPegawai->sub_district_1= $request->sub_district_1;
            $oPegawai->district_1= $request->district_1;
            $oPegawai->city_1= $request->city_1;
            $oPegawai->province_1= $request->province_1;
            $oPegawai->country_1= $request->country_1;
            $oPegawai->phone_number_1= $request->phone_number_1;
            $oPegawai->postal_code_1= $request->postal_code_1;
            $oPegawai->address_2= $request->address_2;
            $oPegawai->sub_district_2= $request->sub_district_2;
            $oPegawai->district_2= $request->district_2;
            $oPegawai->city_2= $request->city_2;
            $oPegawai->province_2= $request->province_2;
            $oPegawai->country_2= $request->country_2;
            $oPegawai->phone_number_2= $request->phone_number_2;
            $oPegawai->postal_code_2= $request->postal_code_2;
            $oPegawai->ktp_number= $request->ktp_number;
            $oPegawai->ktp_validity_period= $request->ktp_validity_period;
            $oPegawai->sim_a_number= $request->sim_a_number;
            $oPegawai->sim_a_validity_period= $request->sim_a_validity_period;
            $oPegawai->sim_c_number= $request->sim_c_number;
            $oPegawai->sim_c_validity_period= $request->sim_c_validity_period;
            $oPegawai->father_name= $request->father_name;
            $oPegawai->mother_name= $request->mother_name;
            $oPegawai->blood_type= $request->blood_type;
            if (strlen($fileName)>0){
                $oPegawai->eployee_photo_file= $fileName;
            }else{
                $oPegawai->eployee_photo_file= "";
            }
            $oPegawai->leave_status= $request->leave_status;
            $oPegawai->remaining_day_off_1= $request->remaining_day_off_1;
            $oPegawai->remaining_day_off_2= $request->remaining_day_off_2;
            $oPegawai->new_employee_id= $request->new_employee_id;
            $oPegawai->resign_reason= $request->resign_reason;
            $oPegawai->fingerprint_id= $request->fingerprint_id;
            $oPegawai->first_employee_id= $request->first_employee_id;
            $oPegawai->contract_counter= $request->contract_counter;
            $oPegawai->employee_type_code = $request->employee_type_code;


            $oPegawai->save();

           /* //save to employee organization 
            $oEmployeeOrganization = new EmployeeOrganization();
            $oEmployeeOrganization->employee_id = $request->employee_id;
            $oEmployeeOrganization->org_code = $request->organization_code;
            $oEmployeeOrganization->user_input = $request->get('userLoginId');
            $oEmployeeOrganization->user_edit = $request->get('userLoginId');
            $oEmployeeOrganization->save();*/
            
            //save to salary employee
            $salaryEmployeeArr = $request->salary_employee;
            
            for ($x=0;$x<count($salaryEmployeeArr);$x++){
                $oSalaryEmployee = new SalaryEmployee();
                $oSalaryEmployee->employee_id = $request->employee_id;
                $oSalaryEmployee->salary_code = $salaryEmployeeArr[$x]['salary_code'];
                $oSalaryEmployee->amount = $salaryEmployeeArr[$x]['amount'];
                $oSalaryEmployee->description = $salaryEmployeeArr[$x]['description'];
                $oSalaryEmployee->user_input = $request->get('userLoginId');
                $oSalaryEmployee->user_edit = $request->get('userLoginId');
                $oSalaryEmployee->save();
            }

            //save to employee organization
            $organization_employeeArr = $request->organization_employee;
            $oganization_employee_dataArr = $request->oganization_employee_data;

            for ($x=0;$x<count($organization_employeeArr);$x++){
                $oEmployeeOrganization = new EmployeeOrganization();

                $oEmployeeOrganization->employee_id =$request->employee_id;
                $oEmployeeOrganization->org_level_code = $organization_employeeArr[$x];
                if($oganization_employee_dataArr[$x] == "") $oganization_employee_dataArr[$x] = "-";
                $oEmployeeOrganization->org_code = $oganization_employee_dataArr[$x];
                $oEmployeeOrganization->user_input = $request->get('userLoginId');
                $oEmployeeOrganization->user_edit = $request->get('userLoginId');
                $oEmployeeOrganization->save();
            }
            
            

           
            

            return $this->sendResponse($oPegawai, $this->successStatus);

        }catch (\Exception $e){
            return $this->sendError(500, ['error'=> $e]);
        }
        


        
    }

    
    public function show($id)
    {
        
        try{
            $oPegawai = Pegawai::with('get_ptkp_status','get_bpjs_rate','get_education','get_family','get_job_history','get_position_history','get_historical_training.training_type','get_historical_salary','get_historical_leaves','get_sanction_historical','get_employee_type')->find($id);

            if ($oPegawai) {
                return $this->sendResponse($oPegawai, $this->successStatus);
            }else{
                return $this->sendError(404, ['error'=> 'Pegawai does not exist.']);
            }
        }catch (\Exception $e){
            return $this->sendError(500, ['error'=> $e]);
        }
    }

    
    public function update(UpdateRequest $request, $id)
    {
        try{
            $oPegawai = Pegawai::find($id);

            if ($oPegawai) {
                //find the company name, so it can store image on the right directory
                //list($companyName) = explode('.', $request->getHost(), 2);
                $companyName = $request->user()->company_name;
                $company = Company::where("company_name",$companyName)->first();

                //files            
                $path = "";
                $fileName ="";
                
                if ($request->hasFile('eployee_photo_file')) {
                    //delete old photo
                    if (strlen($oPegawai->eployee_photo_file)>0){
                        //check if this pegawai has a photo
                        if(file_exists(public_path().'/'.$company->company_name.'/'.$oPegawai->eployee_photo_file)){
                            //if the file exist the delete
                            File::delete(public_path().'/'.$company->company_name.'/'.$oPegawai->eployee_photo_file);
                        }
                    }
                    //upload new photo
                    if (! File::exists(public_path()."/".$company->company_name."")) {
                        // if not then make new folder            
                        File::makeDirectory(public_path()."/".$company->company_name."",$mode = 0777, true, true);
                    }
                    //upload the file
                    $fileName = Uuid::uuid4()->getHex().".jpg";
                    $path = $request->file('eployee_photo_file')->move(public_path('/'.$company->company_name.'/'),$fileName); 
                   
                }

                $oPegawai->first_name= $request->first_name;
                $oPegawai->middle_name= $request->middle_name;
                $oPegawai->last_name= $request->last_name;
                $oPegawai->alias_name= $request->alias_name;
                $oPegawai->kode_status_ptkp= $request->kode_status_ptkp;
                $oPegawai->kode_tarif_jamsostek= $request->kode_tarif_jamsostek;
                $oPegawai->join_date= $request->join_date;
                $oPegawai->resign_date= $request->resign_date;
                $oPegawai->contract_begin_date= $request->contract_begin_date;
                $oPegawai->contract_end_date= $request->contract_end_date;
                $oPegawai->employee_active_status= $request->employee_active_status;
                $oPegawai->handphone_number= $request->handphone_number;
                $oPegawai->pkwt_number= $request->pkwt_number;
                $oPegawai->email_1= $request->email_1;
                $oPegawai->email_2= $request->email_2;
                $oPegawai->bank_account_number_1= $request->bank_account_number_1;
                $oPegawai->bank_name_1= $request->bank_name_1;
                $oPegawai->bank_account_name_1= $request->bank_account_name_1;
                $oPegawai->bank_branch_name_1= $request->bank_branch_name_1;
                $oPegawai->bank_account_number_2= $request->bank_account_number_2;
                $oPegawai->bank_name_2= $request->bank_name_2;
                $oPegawai->bank_account_name_2= $request->bank_account_name_2;
                $oPegawai->bank_branch_name_2= $request->bank_branch_name_2;
                $oPegawai->birth_place= $request->birth_place;
                $oPegawai->birth_date= $request->birth_date;
                $oPegawai->gender= $request->gender;
                $oPegawai->citizen= $request->citizen;
                $oPegawai->religion= $request->religion;
                $oPegawai->marital_status= $request->marital_status;
                $oPegawai->number_of_dependents= $request->number_of_dependents;
                $oPegawai->salary_tax_type= $request->salary_tax_type;
                $oPegawai->ptkp_status= $request->ptkp_status;
                $oPegawai->saldo_pendapatan= $request->saldo_pendapatan;
                $oPegawai->saldo_pajak= $request->saldo_pajak;
                $oPegawai->salary_month_begin= $request->salary_month_begin;
                $oPegawai->salary_month_end= $request->salary_month_end;
                $oPegawai->overtime_status= $request->overtime_status;
                $oPegawai->shift_code= $request->shift_code;
                $oPegawai->npwp_number= $request->npwp_number;
                $oPegawai->npwp_activation_date= $request->npwp_activation_date;
                $oPegawai->npwp_status= $request->npwp_status;
                $oPegawai->bpjs_number= $request->bpjs_number;
                $oPegawai->bpjs_activation_date= $request->bpjs_activation_date;
                $oPegawai->bpjs_status= $request->bpjs_status;
                $oPegawai->pension_number= $request->pension_number;
                $oPegawai->pension_active_date= $request->pension_active_date;
                $oPegawai->pension_status= $request->pension_status;
                $oPegawai->address_1= $request->address_1;
                $oPegawai->sub_district_1= $request->sub_district_1;
                $oPegawai->district_1= $request->district_1;
                $oPegawai->city_1= $request->city_1;
                $oPegawai->province_1= $request->province_1;
                $oPegawai->country_1= $request->country_1;
                $oPegawai->phone_number_1= $request->phone_number_1;
                $oPegawai->postal_code_1= $request->postal_code_1;
                $oPegawai->address_2= $request->address_2;
                $oPegawai->sub_district_2= $request->sub_district_2;
                $oPegawai->district_2= $request->district_2;
                $oPegawai->city_2= $request->city_2;
                $oPegawai->province_2= $request->province_2;
                $oPegawai->country_2= $request->country_2;
                $oPegawai->phone_number_2= $request->phone_number_2;
                $oPegawai->postal_code_2= $request->postal_code_2;
                $oPegawai->ktp_number= $request->ktp_number;
                $oPegawai->ktp_validity_period= $request->ktp_validity_period;
                $oPegawai->sim_a_number= $request->sim_a_number;
                $oPegawai->sim_a_validity_period= $request->sim_a_validity_period;
                $oPegawai->sim_c_number= $request->sim_c_number;
                $oPegawai->sim_c_validity_period= $request->sim_c_validity_period;
                $oPegawai->father_name= $request->father_name;
                $oPegawai->mother_name= $request->mother_name;
                $oPegawai->blood_type= $request->blood_type;
                if (strlen($fileName)>0){
                    $oPegawai->eployee_photo_file= $fileName;
                }
                $oPegawai->leave_status= $request->leave_status;
                $oPegawai->remaining_day_off_1= $request->remaining_day_off_1;
                $oPegawai->remaining_day_off_2= $request->remaining_day_off_2;
                $oPegawai->new_employee_id= $request->new_employee_id;
                $oPegawai->resign_reason= $request->resign_reason;
                $oPegawai->fingerprint_id= $request->fingerprint_id;
                $oPegawai->first_employee_id= $request->first_employee_id;
                $oPegawai->contract_counter= $request->contract_counter;
                $oPegawai->employee_type_code = $request->employee_type_code;
                $oPegawai->save();

                return $this->sendResponse($oPegawai, $this->successStatus);
            }else{
                return $this->sendError(404, ['error'=> 'Pegawai does not exist.']);
            }
        }catch (\Exception $e){
            return $this->sendError(500, ['error'=> $e]);
        }
    }

    
    public function destroy($id)
    {
        try{
            $oPegawai = Pegawai::find($id);

            if ($oPegawai) {               
                $oPegawai->delete();
                return $this->sendResponse($oPegawai, $this->successStatus);
            }else{
                return $this->sendError(404, ['error'=> 'Pegawai does not exist.']);
            }
        }catch (\Exception $e){
            return $this->sendError(500, ['error'=> $e]);
        }
    }

    public function photoId(Request $request,$id){
        //list($companyName) = explode('.', $request->getHost(), 2);
        $companyName = $request->user()->company_name;
        $company = Company::where("company_name",$companyName)->first();
        $path = public_path()."/".$company->company_name."/".$id."";
        return response()->download($path);
    }

    public function photoByObject(Request $request,$id){
        //list($companyName) = explode('.', $request->getHost(), 2);
        $companyName = $request->user()->company_name;
        $company = Company::where("company_name",$companyName)->first();

        try{
            $oPegawai = Pegawai::find($id);
            
            if ($oPegawai) {
                $path = public_path()."/".$company->company_name."/".$oPegawai->eployee_photo_file."";
                return response()->download($path);
                //echo $path;
            }else{
                return $this->sendError(404, ['error'=> 'Pegawai does not exist.']);
            }
        }catch(\Exception $e){
            return $this->sendError(500, ['error'=> $e]);
        }
        
    }

    public function checkValidate(Request $request){
        
        $step = $request->step;

        switch($step){
            case 1 :
                $validator = Validator::make($request->all(), [
                    'employee_id' => 'required|unique:tenant.pegawai|max:50',
                    'first_name' => 'required|max:100',
                    'middle_name' => 'max:100',
                    'last_name' => 'max:100',
                    'alias_name' => 'max:100',
                    'join_date' => 'required|date',
                    'employee_type_code' => 'required|max:50',
                    'contract_begin_date' => 'required|date',
                    'contract_end_date' => 'required|date',
                    'pkwt_number' => 'required|max:50',
                    'fingerprint_id' => 'max:50',
                    'shift_code' => 'required|max:50',
                    'organization_code' => 'required'

                ]);
                if ($validator->fails()) {
                    return $this->sendError(500, ['error'=> $validator->errors()]);                  
                }else{
                    return $this->sendError(200, ['error'=> $validator->errors()]);
                }
            break;
            case 2 : 
                $validator = Validator::make($request->all(), [
                    'handphone_number' => 'required|max:50',
                    'phone_number_1' => 'max:20',
                    'email_1' =>'required|email',
                    'country_1' => 'required|max:100',
                    'province_1' => 'max:100',
                    'city_1' => 'max:100',
                    'district_1' => 'max:100',
                    'sub_district_1' => 'max:100',
                    'address_1' =>'required',
                    'postal_code_1' => 'max:10'
                ]);
                if ($validator->fails()) {
                    return $this->sendError(500, ['error'=> $validator->errors()]);                  
                }else{
                    return $this->sendError(200, ['error'=> $validator->errors()]);
                }
            break;
            case 3 : 
                $validator = Validator::make($request->all(), [
                    'birth_place' => 'required|max:50',
                    'birth_date' => 'required|date',
                    'gender' => 'required|max:50',
                    'citizen' => 'required|max:20',
                    'religion' => 'max:50',
                    'marital_status' => 'required|max:50',
                    'number_of_dependents' => 'required|integer',
                    'bank_name_1' => 'required|max:50',
                    'bank_account_name_1' => 'required|max:50',
                    'bank_account_number_1' => 'required|max:50',
                    'bank_branch_name_1' => 'required|max:50'
                ]);
                if ($validator->fails()) {
                    return $this->sendError(500, ['error'=> $validator->errors()]);                  
                }else{
                    return $this->sendError(200, ['error'=> $validator->errors()]);
                }
            break;
            case 5: 
                $validator = Validator::make($request->all(), [
                    'kode_status_ptkp' => 'required',
                    'salary_tax_type' => 'required|integer',
                    'npwp_status' => 'required|integer',
                    'salary_month_begin' => 'required|integer',
                    'salary_month_end' => 'required|integer',
                    'saldo_pendapatan' => 'numeric',
                    'saldo_pajak' => 'numeric',
                    'overtime_status' => 'required|integer',
                    'bpjs_status' => 'required|integer',
                ]);
                if ($validator->fails()) {
                    return $this->sendError(500, ['error'=> $validator->errors()]);                  
                }else{
                    return $this->sendError(200, ['error'=> $validator->errors()]);
                }
            break;
        }

    }
}
