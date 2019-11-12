<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Tenant\MedicalCheckUpEmployee;
use App\Http\Requests\MedicalCheckUpEmployee\StoreRequest;
use App\Http\Requests\MedicalCheckUpEmployee\UpdateRequest;

class MedicalCheckUpEmployeeController extends Controller
{
    public function index(){
        try{
            $lsMedicalCheckUpEmployee = MedicalCheckUpEmployee::with('pegawai','user_i','user_e')->get();            
            return $this->sendResponse($lsMedicalCheckUpEmployee, $this->successStatus);
        }catch (\Exception $e){
            return $this->sendError(500, ['error'=> $e]);
        }
    
    }

    public function listFilterAndPagine(Request $request){
        $filter = $request->filter;
        $count = $request->count;
        try{
            if (strlen($filter)>0){
                $lsMedicalCheckUpEmployee =MedicalCheckUpEmployee::with('pegawai','user_i','user_e')
                    
                    ->whereHas('pegawai', function ($query) use($filter) {
                        $query->where('first_name', 'like', '%' . $filter . '%')
                        ->orWhere('middle_name', 'like', '%' . $filter . '%')
                        ->orWhere('last_name', 'like', '%' . $filter . '%');
                    })
                    ->orWhere('employee_id', 'like', '%' . $filter . '%')
                    ->orWhere('mcu_type', 'like', '%' . $filter . '%')
                    ->orWhere('year', 'like', '%' . $filter . '%')
                    ->orWhere('mcu_date', 'like', '%' . $filter . '%')
                    ->orWhere('age', 'like', '%' . $filter . '%')
                    ->orWhere('body_weight', 'like', '%' . $filter . '%')
                    ->orWhere('body_height', 'like', '%' . $filter . '%')
                    ->orWhere('imtbmi', 'like', '%' . $filter . '%')
                    ->orWhere('right_eye_visus', 'like', '%' . $filter . '%')
                    ->orWhere('left_eye_visus', 'like', '%' . $filter . '%')
                    ->orWhere('color_blind', 'like', '%' . $filter . '%')
                    ->orWhere('physical', 'like', '%' . $filter . '%')
                    ->orWhere('pushup', 'like', '%' . $filter . '%')
                    ->orWhere('blood_pressure1', 'like', '%' . $filter . '%')
                    ->orWhere('blood_pressure2', 'like', '%' . $filter . '%')
                    ->orWhere('respiratory_1', 'like', '%' . $filter . '%')
                    ->orWhere('respiratory_2', 'like', '%' . $filter . '%')
                    ->orWhere('urine_lab', 'like', '%' . $filter . '%')
                    ->orWhere('blood_lab', 'like', '%' . $filter . '%')
                    ->orWhere('hbsag', 'like', '%' . $filter . '%')
                    ->orWhere('radiology', 'like', '%' . $filter . '%')
                    ->orWhere('audiometry', 'like', '%' . $filter . '%')
                    ->orWhere('blood_type', 'like', '%' . $filter . '%')
                    ->orWhere('rhesus', 'like', '%' . $filter . '%')
                    ->orWhere('ekg', 'like', '%' . $filter . '%')
                    ->orWhere('conclusion', 'like', '%' . $filter . '%')
                    ->orWhere('teeth', 'like', '%' . $filter . '%')
                    ->orWhere('history_of_disease', 'like', '%' . $filter . '%')
                    ->paginate($count);
            }else{
                $lsMedicalCheckUpEmployee =MedicalCheckUpEmployee::with('pegawai','user_i','user_e')->paginate($count);
            }
            
            
            return $this->sendResponse($lsMedicalCheckUpEmployee, $this->successStatus);
        }catch (\Exception $e){
            return $this->sendError(500, ['error'=> $e]);
        }
    }

    public function show($id){
        try{
            $oMedicalCheckUpEmployee = MedicalCheckUpEmployee::with('pegawai','user_i','user_e')->find($id);

            if ($oMedicalCheckUpEmployee) {
                return $this->sendResponse($oMedicalCheckUpEmployee, $this->successStatus);
            }else{
                return $this->sendError(404, ['error'=> 'Medical Check Up Employee does not exist.']);
            }
        }catch (\Exception $e){
            return $this->sendError(500, ['error'=> $e]);
        }
    }

    public function store(StoreRequest $request){
        try{
            $oMedicalCheckUpEmployee = new MedicalCheckUpEmployee();
            $oMedicalCheckUpEmployee->employee_id = $request->employee_id;
            $oMedicalCheckUpEmployee->mcu_type = $request->mcu_type;
            $oMedicalCheckUpEmployee->year = $request->year;
            $oMedicalCheckUpEmployee->mcu_date = $request->mcu_date;
            $oMedicalCheckUpEmployee->age = $request->age;
            $oMedicalCheckUpEmployee->body_weight = $request->body_weight;
            $oMedicalCheckUpEmployee->body_height = $request->body_height;
            $oMedicalCheckUpEmployee->imtbmi = $request->imtbmi;
            $oMedicalCheckUpEmployee->right_eye_visus = $request->right_eye_visus;
            $oMedicalCheckUpEmployee->left_eye_visus = $request->left_eye_visus;
            $oMedicalCheckUpEmployee->color_blind = $request->color_blind;
            $oMedicalCheckUpEmployee->physical = $request->physical;
            $oMedicalCheckUpEmployee->pushup = $request->pushup;
            $oMedicalCheckUpEmployee->blood_pressure1 = $request->blood_pressure1;
            $oMedicalCheckUpEmployee->blood_pressure2 = $request->blood_pressure2;
            $oMedicalCheckUpEmployee->respiratory_1 = $request->respiratory_1;
            $oMedicalCheckUpEmployee->respiratory_2 = $request->respiratory_2;
            $oMedicalCheckUpEmployee->urine_lab = $request->urine_lab;
            $oMedicalCheckUpEmployee->blood_lab = $request->blood_lab;
            $oMedicalCheckUpEmployee->hbsag = $request->hbsag;
            $oMedicalCheckUpEmployee->radiology = $request->radiology;
            $oMedicalCheckUpEmployee->audiometry = $request->audiometry;
            $oMedicalCheckUpEmployee->blood_type = $request->blood_type;
            $oMedicalCheckUpEmployee->rhesus = $request->rhesus;
            $oMedicalCheckUpEmployee->ekg = $request->ekg;
            $oMedicalCheckUpEmployee->conclusion = $request->conclusion;
            $oMedicalCheckUpEmployee->teeth = $request->teeth;
            $oMedicalCheckUpEmployee->history_of_disease = $request->history_of_disease;
            $oMedicalCheckUpEmployee->user_input = $request->get('userLoginId');
            $oMedicalCheckUpEmployee->user_edit = $request->get('userLoginId');
            $oMedicalCheckUpEmployee->save();
            return $this->sendResponse($oMedicalCheckUpEmployee, $this->successStatus);
        }catch (\Exception $e){
            return $this->sendError(500, ['error'=> $e]);
        }
    }

    public function update(UpdateRequest $request,$id){
        try{
            $oMedicalCheckUpEmployee = MedicalCheckUpEmployee::find($id);

            if ($oMedicalCheckUpEmployee) {
                $oMedicalCheckUpEmployee->employee_id = $request->employee_id;
                $oMedicalCheckUpEmployee->mcu_type = $request->mcu_type;
                $oMedicalCheckUpEmployee->year = $request->year;
                $oMedicalCheckUpEmployee->mcu_date = $request->mcu_date;
                $oMedicalCheckUpEmployee->age = $request->age;
                $oMedicalCheckUpEmployee->body_weight = $request->body_weight;
                $oMedicalCheckUpEmployee->body_height = $request->body_height;
                $oMedicalCheckUpEmployee->imtbmi = $request->imtbmi;
                $oMedicalCheckUpEmployee->right_eye_visus = $request->right_eye_visus;
                $oMedicalCheckUpEmployee->left_eye_visus = $request->left_eye_visus;
                $oMedicalCheckUpEmployee->color_blind = $request->color_blind;
                $oMedicalCheckUpEmployee->physical = $request->physical;
                $oMedicalCheckUpEmployee->pushup = $request->pushup;
                $oMedicalCheckUpEmployee->blood_pressure1 = $request->blood_pressure1;
                $oMedicalCheckUpEmployee->blood_pressure2 = $request->blood_pressure2;
                $oMedicalCheckUpEmployee->respiratory_1 = $request->respiratory_1;
                $oMedicalCheckUpEmployee->respiratory_2 = $request->respiratory_2;
                $oMedicalCheckUpEmployee->urine_lab = $request->urine_lab;
                $oMedicalCheckUpEmployee->blood_lab = $request->blood_lab;
                $oMedicalCheckUpEmployee->hbsag = $request->hbsag;
                $oMedicalCheckUpEmployee->radiology = $request->radiology;
                $oMedicalCheckUpEmployee->audiometry = $request->audiometry;
                $oMedicalCheckUpEmployee->blood_type = $request->blood_type;
                $oMedicalCheckUpEmployee->rhesus = $request->rhesus;
                $oMedicalCheckUpEmployee->ekg = $request->ekg;
                $oMedicalCheckUpEmployee->conclusion = $request->conclusion;
                $oMedicalCheckUpEmployee->teeth = $request->teeth;
                $oMedicalCheckUpEmployee->history_of_disease = $request->history_of_disease;
                $oMedicalCheckUpEmployee->user_edit = $request->get('userLoginId');
                $oMedicalCheckUpEmployee->save();
                return $this->sendResponse($oMedicalCheckUpEmployee, $this->successStatus);
            }else{
                return $this->sendError(404, ['error'=> 'Medical Check Up Employee does not exist.']);
            }
        }catch (\Exception $e){
            return $this->sendError(500, ['error'=> $e]);
        }
    }

    public function destroy($id){
        try{
            $oMedicalCheckUpEmployee = MedicalCheckUpEmployee::find($id);

            if ($oMedicalCheckUpEmployee) {               
                $oMedicalCheckUpEmployee->delete();
                return $this->sendResponse($oMedicalCheckUpEmployee, $this->successStatus);
            }else{
                return $this->sendError(404, ['error'=> 'Medical Check Up Employee does not exist.']);
            }
        }catch (\Exception $e){
            return $this->sendError(500, ['error'=> $e]);
        }
    }
}
