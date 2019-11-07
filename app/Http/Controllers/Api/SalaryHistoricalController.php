<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Tenant\SalaryHistorical;
use App\Http\Requests\SalaryHistorical\StoreRequest;
use App\Http\Requests\SalaryHistorical\UpdateRequest;

class SalaryHistoricalController extends Controller
{
    public function index(){
        try {
            $lsSalaryHistorical = SalaryHistorical::with('user_input','user_edit')->get();            
            return $this->sendResponse($lsSalaryHistorical, $this->successStatus);
        } catch (\Exception $e) {
            return $this->sendError(500, ['error'=> $e]);
        }
    }

    public function listFilterAndPagine(Request $request){
        $filter = $request->filter;
        $count = $request->count;
        $employeeId = $request->employee_id;
        if ($employeeId){
            try{
                if (strlen($filter)>0){
                    
                    $lsSalaryHistorical = SalaryHistorical::with('user_input','user_edit')
                        ->where('employee_id', '=', ''.$employeeId.'')
                        ->where(function ($query) use($filter) {
                            $query->where('salary_code', 'like', '%' . $filter . '%')
                            ->orWhere('old_amount', 'like', '%' . $filter . '%')
                            ->orWhere('new_amount', 'like', '%' . $filter . '%')
                            ->orWhere('change_date', 'like', '%' . $filter . '%')
                            ->orWhere('active_date', 'like', '%' . $filter . '%')
                            ->orWhere('description', 'like', '%' . $filter . '%');                           
                        })->paginate($count);
                                
                }else{
                    $lsSalaryHistorical = SalaryHistorical::with('user_input','user_edit')->paginate($count);
                }
    
                return $this->sendResponse($lsSalaryHistorical, $this->successStatus);
            }catch (\Exception $e){
                return $this->sendError(500, ['error'=> $e]);
            }
        }else{
            return $this->sendError(404, ['error'=> 'employee_id is required']);
        }      
    }

    public function show($id){
        try{
            $oSalaryHistorical = SalaryHistorical::with('user_input','user_edit')->find($id);

            if ($oSalaryHistorical) {
                return $this->sendResponse($oSalaryHistorical, $this->successStatus);
            }else{
                return $this->sendError(404, ['error'=> 'Salary Historical does not exist.']);
            }
        }catch (\Exception $e){
            return $this->sendError(500, ['error'=> $e]);
        }
    }

    public function store(StoreRequest $request){
        try {
            $oSalaryHistorical = new SalaryHistorical();
            $oSalaryHistorical->employee_id = $request->employee_id;
            $oSalaryHistorical->salary_code = $request->salary_code;
            $oSalaryHistorical->old_amount = $request->old_amount;
            $oSalaryHistorical->new_amount = $request->new_amount;
            $oSalaryHistorical->change_date = $request->change_date;
            $oSalaryHistorical->active_date = $request->active_date;
            $oSalaryHistorical->description = $request->description;
            $oSalaryHistorical->user_input = $request->get('userLoginId'); 
            $oSalaryHistorical->user_edit = $request->get('userLoginId'); 
            $oSalaryHistorical->save();
            return $this->sendResponse($oSalaryHistorical, $this->successStatus);
        } catch (\Exception $e) {
            return $this->sendError(500, ['error'=> $e]);
        }
    }

    public function update(UpdateRequest $request,$id){
        try{
            $oSalaryHistorical = SalaryHistorical::find($id);

            if ($oSalaryHistorical) {
                $oSalaryHistorical->employee_id = $request->employee_id;
                $oSalaryHistorical->salary_code = $request->salary_code;
                $oSalaryHistorical->old_amount = $request->old_amount;
                $oSalaryHistorical->new_amount = $request->new_amount;
                $oSalaryHistorical->change_date = $request->change_date;
                $oSalaryHistorical->active_date = $request->active_date;
                $oSalaryHistorical->description = $request->description;
                $oSalaryHistorical->user_edit = $request->get('userLoginId'); 
                $oSalaryHistorical->save();
                return $this->sendResponse($oSalaryHistorical, $this->successStatus);
            }else{
                return $this->sendError(404, ['error'=> 'Salary Historical does not exist.']);
            }
        }catch (\Exception $e){
            return $this->sendError(500, ['error'=> $e]);
        }
    }

    public function destroy($id){
        try {
            $oSalaryHistorical = SalaryHistorical::find($id);
            if ($oSalaryHistorical) {
                $oSalaryHistorical->delete();
                return $this->sendResponse($oSalaryHistorical, $this->successStatus);
            }else{
                return $this->sendError(404, ['error'=> 'Salary Historical does not exist.']);
            }
        } catch (\Exception $e) {
            return $this->sendError(500, ['error'=> $e]);
        
        }
    }
}
