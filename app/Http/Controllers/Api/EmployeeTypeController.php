<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Tenant\EmployeeType;
use App\Http\Requests\EmployeeType\StoreRequest;
use App\Http\Requests\EmployeeType\UpdateRequest;

class EmployeeTypeController extends Controller
{
    public function index(){
        try{
            $lsEmployeeType = EmployeeType::with('user_i','user_e')->get();            
            return $this->sendResponse($lsEmployeeType, $this->successStatus);
        }catch (\Exception $e){
            return $this->sendError(500, ['error'=> $e]);
        }
    }

    public function listFilterAndPagine(Request $request){
        $filter = $request->filter;
        $count = $request->count;
               
        try{
            if (strlen($filter)>0){
                
                $lsEmployeeType = EmployeeType::with('user_i','user_e')
                    ->where('employee_type_code', 'like', '%' . $filter . '%')
                    ->orWhere('employee_type_name', 'like', '%' . $filter . '%')
                    ->orWhere('description', 'like', '%' . $filter . '%')
                    ->paginate($count);
                            
            }else{
                $lsEmployeeType = EmployeeType::with('user_i','user_e')->paginate($count);
            }

            return $this->sendResponse($lsEmployeeType, $this->successStatus);
        }catch (\Exception $e){
            return $this->sendError(500, ['error'=> $e]);
        }        
    }

    public function show($id){
        try{
            $oEmployeeType = EmployeeType::find($id);

            if ($oEmployeeType) {
                return $this->sendResponse($oEmployeeType, $this->successStatus);
            }else{
                return $this->sendError(404, ['error'=> 'Employee Type does not exist.']);
            }
        }catch (\Exception $e){
            return $this->sendError(500, ['error'=> $e]);
        }
    }

    public function store(StoreRequest $request){
        try{
            $oEmployeeType = new EmployeeType();
            $oEmployeeType->employee_type_code = $request->employee_type_code;
            $oEmployeeType->employee_type_name = $request->employee_type_name;
            $oEmployeeType->description = $request->description;
            $oEmployeeType->user_input = $request->get('userLoginId');  
            $oEmployeeType->user_edit = $request->get('userLoginId');       
            $oEmployeeType->save();
            return $this->sendResponse($oEmployeeType, $this->successStatus);
        }catch (\Exception $e){
            return $this->sendError(500, ['error'=> $e]);
        }
    }

    public function update(UpdateRequest $request,$id){
        try{
            $oEmployeeType = EmployeeType::find($id);

            if ($oEmployeeType) {
                $oEmployeeType->employee_type_code = $request->employee_type_code;
                $oEmployeeType->employee_type_name = $request->employee_type_name;
                $oEmployeeType->description = $request->description;
                $oEmployeeType->user_edit = $request->get('userLoginId');                
                $oEmployeeType->save();
                return $this->sendResponse($oEmployeeType, $this->successStatus);
            }else{
                return $this->sendError(404, ['error'=> 'Employee Type does not exist.']);
            }
        }catch (\Exception $e){
            return $this->sendError(500, ['error'=> $e]);
        }
    }

    public function destroy($id){
        try{
            $oEmployeeType = EmployeeType::find($id);

            if ($oEmployeeType) {               
                $oEmployeeType->delete();
                return $this->sendResponse($oEmployeeType, $this->successStatus);
            }else{
                return $this->sendError(404, ['error'=> 'Employee Type does not exist.']);
            }
        }catch (\Exception $e){
            return $this->sendError(500, ['error'=> $e]);
        }
    }
}
