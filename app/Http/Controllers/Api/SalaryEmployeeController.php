<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Tenant\SalaryEmployee;
use App\Http\Requests\SalaryEmployee\StoreRequest;
use App\Http\Requests\SalaryEmployee\UpdateRequest;

class SalaryEmployeeController extends Controller
{
    public function index(){
        try {
            $lsSalaryEmployee = SalaryEmployee::with('pegawai','salary','user_i','user_e')->get();            
            return $this->sendResponse($lsSalaryEmployee, $this->successStatus);
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
                    
                    $lsSalaryEmployee = SalaryEmployee::with('pegawai','salary','user_i','user_e')
                        ->where('employee_id', '=', ''.$employeeId.'')
                        ->where(function ($query) use($filter) {
                            $query->where('salary_code', 'like', '%' . $filter . '%')
                            ->orWhere('amount', 'like', '%' . $filter . '%')
                            ->orWhere('description', 'like', '%' . $filter . '%')
                            ->orWhereHas('salary', function ($query) use($filter) {
                                $query->where('salary_name', 'like', '%' . $filter . '%');
                            });                           
                        })->paginate($count);
                                
                }else{
                    $lsSalaryEmployee = SalaryEmployee::with('pegawai','salary','user_i','user_e')
                        ->where('employee_id', '=', ''.$employeeId.'')
                        ->paginate($count);
                }
    
                return $this->sendResponse($lsSalaryEmployee, $this->successStatus);
            }catch (\Exception $e){
                return $this->sendError(500, ['error'=> $e]);
            }
        }else{
            return $this->sendError(404, ['error'=> 'employee_id is required']);
        }  
    }

    public function show($id){
        try{
            $oSalaryEmployee = SalaryEmployee::with('pegawai','salary','user_i','user_e')->find($id);

            if ($oSalaryEmployee) {
                return $this->sendResponse($oSalaryEmployee, $this->successStatus);
            }else{
                return $this->sendError(404, ['error'=> 'Salary Employee does not exist.']);
            }
        }catch (\Exception $e){
            return $this->sendError(500, ['error'=> $e]);
        }
    }

    public function store(StoreRequest $request){
        try {
            $oSalaryEmployee = new SalaryEmployee();
            $oSalaryEmployee->employee_id = $request->employee_id;
            $oSalaryEmployee->salary_code = $request->salary_code;
            $oSalaryEmployee->amount = $request->amount;
            $oSalaryEmployee->description = $request->description;
            $oSalaryEmployee->user_input = $request->get('userLoginId'); 
            $oSalaryEmployee->user_edit = $request->get('userLoginId'); 
            $oSalaryEmployee->save();
            return $this->sendResponse($oSalaryEmployee, $this->successStatus);
        } catch (\Exception $e) {
            return $this->sendError(500, ['error'=> $e]);
        }
    }

    public function update(UpdateRequest $request,$id){
        try{
            $oSalaryEmployee = SalaryEmployee::find($id);

            if ($oSalaryEmployee) {
                $oSalaryEmployee->employee_id = $request->employee_id;
                $oSalaryEmployee->salary_code = $request->salary_code;
                $oSalaryEmployee->amount = $request->amount;
                $oSalaryEmployee->description = $request->description;
                $oSalaryEmployee->user_edit = $request->get('userLoginId'); 
                $oSalaryEmployee->save();
                return $this->sendResponse($oSalaryEmployee, $this->successStatus);
            }else{
                return $this->sendError(404, ['error'=> 'Salary Employee does not exist.']);
            }
        }catch (\Exception $e){
            return $this->sendError(500, ['error'=> $e]);
        }
    }

    public function destroy($id){
        try {
            $oSalaryEmployee = SalaryEmployee::find($id);
            if ($oSalaryEmployee) {
                $oSalaryEmployee->delete();
                return $this->sendResponse($oSalaryEmployee, $this->successStatus);
            }else{
                return $this->sendError(404, ['error'=> 'Salary Employee does not exist.']);
            }
        } catch (\Exception $e) {
            return $this->sendError(500, ['error'=> $e]);
        
        }
    }
}
