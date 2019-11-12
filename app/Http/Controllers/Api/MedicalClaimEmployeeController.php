<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Tenant\MedicalClaimEmployee;
use App\Http\Requests\MedicalClaimEmployee\StoreRequest;
use App\Http\Requests\MedicalClaimEmployee\UpdateRequest;

class MedicalClaimEmployeeController extends Controller
{
    public function index(){
        try{
            $lsMedicalClaimEmployee = MedicalClaimEmployee::with('pegawai','approval','user_i','user_e')->get();            
            return $this->sendResponse($lsMedicalClaimEmployee, $this->successStatus);
        }catch (\Exception $e){
            return $this->sendError(500, ['error'=> $e]);
        }
    
    }

    public function listFilterAndPagine(Request $request){
        $filter = $request->filter;
        $count = $request->count;
        try{
            if (strlen($filter)>0){
                $lsMedicalClaimEmployee = MedicalClaimEmployee::with('pegawai','approval','user_i','user_e')
                    
                    ->whereHas('pegawai', function ($query) use($filter) {
                        $query->where('first_name', 'like', '%' . $filter . '%')
                        ->orWhere('middle_name', 'like', '%' . $filter . '%')
                        ->orWhere('last_name', 'like', '%' . $filter . '%');
                    })
                    ->whereHas('approval', function ($query) use($filter) {
                        $query->where('first_name', 'like', '%' . $filter . '%')
                        ->orWhere('middle_name', 'like', '%' . $filter . '%')
                        ->orWhere('last_name', 'like', '%' . $filter . '%');
                    })
                    ->orWhere('employee_id', 'like', '%' . $filter . '%')
                    ->orWhere('claim_date', 'like', '%' . $filter . '%')
                    ->orWhere('approval_date', 'like', '%' . $filter . '%')
                    ->orWhere('approval_by', 'like', '%' . $filter . '%')
                    ->orWhere('claim_type', 'like', '%' . $filter . '%')
                    ->orWhere('claim_purpose', 'like', '%' . $filter . '%')
                    ->orWhere('clinic_name', 'like', '%' . $filter . '%')
                    ->orWhere('description', 'like', '%' . $filter . '%')
                    ->orWhere('approval_status', 'like', '%' . $filter . '%')
                    ->orWhere('total_claim_amount', 'like', '%' . $filter . '%')
                    ->orWhere('total_claim_approved', 'like', '%' . $filter . '%')
                    ->paginate($count);
            }else{
                $lsMedicalClaimEmployee = MedicalClaimEmployee::with('pegawai','approval','user_i','user_e')->paginate($count);
            }
            
            
            return $this->sendResponse($lsMedicalClaimEmployee, $this->successStatus);
        }catch (\Exception $e){
            return $this->sendError(500, ['error'=> $e]);
        }
    }

    public function show($id){
        try{
            $oMedicalClaimEmployee = MedicalClaimEmployee::with('pegawai','approval','user_i','user_e')->find($id);

            if ($oMedicalClaimEmployee) {
                return $this->sendResponse($oMedicalClaimEmployee, $this->successStatus);
            }else{
                return $this->sendError(404, ['error'=> 'Medical Claim Employee does not exist.']);
            }
        }catch (\Exception $e){
            return $this->sendError(500, ['error'=> $e]);
        }
    }

    public function store(StoreRequest $request){
        try{
            $oMedicalClaimEmployee = new MedicalClaimEmployee();
            $oMedicalClaimEmployee->submission_number = "SUB.".$request->user()->company_name.".".date('YmdHis');
            $oMedicalClaimEmployee->employee_id = $request->employee_id;
            $oMedicalClaimEmployee->claim_date = $request->claim_date;
            $oMedicalClaimEmployee->approval_date = $request->approval_date;
            $oMedicalClaimEmployee->approval_by = $request->approval_by;
            $oMedicalClaimEmployee->claim_type = $request->claim_type;
            $oMedicalClaimEmployee->claim_purpose = $request->claim_purpose;
            $oMedicalClaimEmployee->clinic_name = $request->clinic_name;
            $oMedicalClaimEmployee->description = $request->description;
            $oMedicalClaimEmployee->approval_status = $request->approval_status;
            $oMedicalClaimEmployee->total_claim_amount = $request->total_claim_amount;
            $oMedicalClaimEmployee->total_claim_approved = $request->total_claim_approved;
            $oMedicalClaimEmployee->approval_description = $request->approval_description;
            $oMedicalClaimEmployee->user_input = $request->get('userLoginId');
            $oMedicalClaimEmployee->user_edit = $request->get('userLoginId');
            $oMedicalClaimEmployee->save();
            return $this->sendResponse($oMedicalClaimEmployee, $this->successStatus);
        }catch (\Exception $e){
            return $this->sendError(500, ['error'=> $e]);
        }
    }

    public function update(UpdateRequest $request,$id){
        try{
            $oMedicalClaimEmployee = MedicalClaimEmployee::find($id);

            if ($oMedicalClaimEmployee) {
                $oMedicalClaimEmployee->employee_id = $request->employee_id;
                $oMedicalClaimEmployee->claim_date = $request->claim_date;
                $oMedicalClaimEmployee->approval_date = $request->approval_date;
                $oMedicalClaimEmployee->approval_by = $request->approval_by;
                $oMedicalClaimEmployee->claim_type = $request->claim_type;
                $oMedicalClaimEmployee->claim_purpose = $request->claim_purpose;
                $oMedicalClaimEmployee->clinic_name = $request->clinic_name;
                $oMedicalClaimEmployee->description = $request->description;
                $oMedicalClaimEmployee->approval_status = $request->approval_status;
                $oMedicalClaimEmployee->total_claim_amount = $request->total_claim_amount;
                $oMedicalClaimEmployee->total_claim_approved = $request->total_claim_approved;
                $oMedicalClaimEmployee->approval_description = $request->approval_description;
                $oMedicalClaimEmployee->user_edit = $request->get('userLoginId');
                $oMedicalClaimEmployee->save();
                return $this->sendResponse($oMedicalClaimEmployee, $this->successStatus);
            }else{
                return $this->sendError(404, ['error'=> 'Medical Claim Employee does not exist.']);
            }
        }catch (\Exception $e){
            return $this->sendError(500, ['error'=> $e]);
        }
    }

    public function destroy($id){
        try{
            $oMedicalClaimEmployee = MedicalClaimEmployee::find($id);

            if ($oMedicalClaimEmployee) {               
                $oMedicalClaimEmployee->delete();
                return $this->sendResponse($oMedicalClaimEmployee, $this->successStatus);
            }else{
                return $this->sendError(404, ['error'=> 'Medical Claim Employee does not exist.']);
            }
        }catch (\Exception $e){
            return $this->sendError(500, ['error'=> $e]);
        }
    }




}
