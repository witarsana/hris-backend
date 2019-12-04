<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Tenant\SalaryMasterData;
use App\Http\Requests\SalaryMasterData\StoreRequest;
use App\Http\Requests\SalaryMasterData\UpdateRequest;

class SalaryMasterDataController extends Controller
{
    public function index(){
        try{
            $lsSalaryMasterData = SalaryMasterData::with('user_i','user_e')->get();
            
            return $this->sendResponse($lsSalaryMasterData, $this->successStatus);
        }catch (\Exception $e){
            return $this->sendError(500, ['error'=> $e]);
        }
    }

    public function listFilterAndPagine(Request $request){
        $filter = $request->filter;
        $count = $request->count;
        try{
            if (strlen($filter)>0){
                $lsSalaryMasterData = SalaryMasterData::with('user_i','user_e')
                            ->where('salary_name', 'like', '%' . $filter . '%')
                            ->orWhere('salary_code', 'like', '%' . $filter . '%')
                            ->orWhere('income_deduction_status', 'like', '%' . $filter . '%')
                            ->orWhere('active_status', 'like', '%' . $filter . '%')
                            ->orWhere('regular_iregular_status', 'like', '%' . $filter . '%')
                            ->orWhere('attendance_related_status', 'like', '%' . $filter . '%')
                            ->orWhere('thr_related_status', 'like', '%' . $filter . '%')
                            ->orWhere('overtime_related_status', 'like', '%' . $filter . '%')
                            ->orWhere('tax_related_status', 'like', '%' . $filter . '%')
                            ->orWhere('bpjstk_related_status', 'like', '%' . $filter . '%')
                            ->orWhere('bpjskes_related_status', 'like', '%' . $filter . '%')
                            ->orWhere('description', 'like', '%' . $filter . '%')
                            ->paginate($count);
            }else{
                $lsSalaryMasterData = SalaryMasterData::with('user_i','user_e')->paginate($count);
            }
            
            
            return $this->sendResponse($lsSalaryMasterData, $this->successStatus);
        }catch (\Exception $e){
            return $this->sendError(500, ['error'=> $e]);
        }
    }

    public function show($id){
        try{
            $oSalaryMasterData = SalaryMasterData::with('user_i','user_e')->find($id);

            if ($oSalaryMasterData) {
                return $this->sendResponse($oSalaryMasterData, $this->successStatus);
            }else{
                return $this->sendError(404, ['error'=> 'Salary Master Data does not exist.']);
            }
        }catch (\Exception $e){
            return $this->sendError(500, ['error'=> $e]);
        }
    }

    public function store(StoreRequest $request){
        try{
            $oSalaryMasterData = new SalaryMasterData();
            $oSalaryMasterData->salary_code = $request->salary_code;
            $oSalaryMasterData->salary_name = $request->salary_name;
            $oSalaryMasterData->income_deduction_status = $request->income_deduction_status;
            $oSalaryMasterData->active_status = $request->active_status;
            $oSalaryMasterData->regular_iregular_status = $request->regular_iregular_status;
            $oSalaryMasterData->attendance_related_status = $request->attendance_related_status;
            $oSalaryMasterData->thr_related_status = $request->thr_related_status;
            $oSalaryMasterData->overtime_related_status = $request->overtime_related_status;
            $oSalaryMasterData->tax_related_status = $request->tax_related_status;
            $oSalaryMasterData->bpjstk_related_status = $request->bpjstk_related_status;
            $oSalaryMasterData->bpjskes_related_status = $request->bpjskes_related_status;
            $oSalaryMasterData->description = $request->description;
            $oSalaryMasterData->user_input = $request->get('userLoginId'); 
            $oSalaryMasterData->user_edit = $request->get('userLoginId'); 
            $oSalaryMasterData->save();
            return $this->sendResponse($oSalaryMasterData, $this->successStatus);
        }catch (\Exception $e){
            return $this->sendError(500, ['error'=> $e]);
        }
    }

    public function update(UpdateRequest $request,$id){
        try{
            $oSalaryMasterData = SalaryMasterData::find($id);

            if ($oSalaryMasterData) {
                $oSalaryMasterData->salary_name = $request->salary_name;
                $oSalaryMasterData->income_deduction_status = $request->income_deduction_status;
                $oSalaryMasterData->active_status = $request->active_status;
                $oSalaryMasterData->regular_iregular_status = $request->regular_iregular_status;
                $oSalaryMasterData->attendance_related_status = $request->attendance_related_status;
                $oSalaryMasterData->thr_related_status = $request->thr_related_status;
                $oSalaryMasterData->overtime_related_status = $request->overtime_related_status;
                $oSalaryMasterData->tax_related_status = $request->tax_related_status;
                $oSalaryMasterData->bpjstk_related_status = $request->bpjstk_related_status;
                $oSalaryMasterData->bpjskes_related_status = $request->bpjskes_related_status;
                $oSalaryMasterData->description = $request->description;
                $oSalaryMasterData->user_edit = $request->get('userLoginId'); 
                $oSalaryMasterData->save();
                return $this->sendResponse($oSalaryMasterData, $this->successStatus);
            }else{
                return $this->sendError(404, ['error'=> 'Salary Master Data does not exist.']);
            }
        }catch (\Exception $e){
            return $this->sendError(500, ['error'=> $e]);
        }
    }

    public function destroy($id){
        try{
            $oSalaryMasterData = SalaryMasterData::find($id);

            if ($oSalaryMasterData) {
                $oSalaryMasterData->delete();
                return $this->sendResponse($oSalaryMasterData, $this->successStatus);
            }else{
                return $this->sendError(404, ['error'=> 'Salary Master Data does not exist.']);
            }
        }catch (\Exception $e){
            return $this->sendError(500, ['error'=> $e]);
        }
    }
}
