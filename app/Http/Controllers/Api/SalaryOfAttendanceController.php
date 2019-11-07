<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Tenant\SalaryOfAttendance;
use App\Http\Requests\SalaryOfAttendance\StoreRequest;
use App\Http\Requests\SalaryOfAttendance\UpdateRequest;

class SalaryOfAttendanceController extends Controller
{
    public function index(){
        try{
            $lsSalaryOfAttendance = SalaryOfAttendance::with('pegawai','salary','user_i','user_e')->get();            
            return $this->sendResponse($lsSalaryOfAttendance, $this->successStatus);
        }catch (\Exception $e){
            return $this->sendError(500, ['error'=> $e]);
        }
    }

    public function listFilterAndPagine(Request $request){
        $filter = $request->filter;
        $count = $request->count;
        try{
            if (strlen($filter)>0){
                $lsSalaryOfAttendance = SalaryOfAttendance::with('pegawai','salary','user_i','user_e')
                    ->whereHas('pegawai', function ($query) use($filter) {
                        $query->where('first_name', 'like', '%' . $filter . '%')
                        ->orWhere('middle_name', 'like', '%' . $filter . '%')
                        ->orWhere('last_name', 'like', '%' . $filter . '%');
                    })
                    ->orWhereHas('salary',function($query) use($filter){
                        $query->where('salary_name', 'like', '%' . $filter . '%');
                    })
                    ->orWhere('amount', 'like', '%' . $filter . '%')
                    ->paginate($count);
            }else{
                $lsSalaryOfAttendance = SalaryOfAttendance::with('pegawai','salary','user_i','user_e')->paginate($count);
            }
            
            
            return $this->sendResponse($lsSalaryOfAttendance, $this->successStatus);
        }catch (\Exception $e){
            return $this->sendError(500, ['error'=> $e]);
        }
    }

    public function show($id){
        try{
            $oSalaryOfAttendance = SalaryOfAttendance::with('pegawai','salary','user_i','user_e')->find($id);

            if ($oSalaryOfAttendance) {
                return $this->sendResponse($oSalaryOfAttendance, $this->successStatus);
            }else{
                return $this->sendError(404, ['error'=> 'Salary Of Attendance does not exist.']);
            }
        }catch (\Exception $e){
            return $this->sendError(500, ['error'=> $e]);
        }
    }

    public function store(StoreRequest $request){
        try{
            $oSalaryOfAttendance = new SalaryOfAttendance();
            $oSalaryOfAttendance->employee_id = $request->employee_id;
            $oSalaryOfAttendance->date = $request->date;
            $oSalaryOfAttendance->salary_code = $request->salary_code;
            $oSalaryOfAttendance->amount = $request->amount;
            $oSalaryOfAttendance->user_input = $request->get('userLoginId');
            $oSalaryOfAttendance->user_edit = $request->get('userLoginId');
            $oSalaryOfAttendance->save();
            return $this->sendResponse($oSalaryOfAttendance, $this->successStatus);
        }catch (\Exception $e){
            return $this->sendError(500, ['error'=> $e]);
        }
    }

    public function update(UpdateRequest $request,$id){
        try{
            $oSalaryOfAttendance = SalaryOfAttendance::find($id);

            if ($oSalaryOfAttendance) {
                $oSalaryOfAttendance->employee_id = $request->employee_id;
                $oSalaryOfAttendance->date = $request->date;
                $oSalaryOfAttendance->salary_code = $request->salary_code;
                $oSalaryOfAttendance->amount = $request->amount;
                $oSalaryOfAttendance->user_edit = $request->get('userLoginId');
                $oSalaryOfAttendance->save();
                return $this->sendResponse($oSalaryOfAttendance, $this->successStatus);
            }else{
                return $this->sendError(404, ['error'=> 'Salary Of Attendance does not exist.']);
            }
        }catch (\Exception $e){
            return $this->sendError(500, ['error'=> $e]);
        }
    }

    public function destroy($id){
        try{
            $oSalaryOfAttendance = SalaryOfAttendance::find($id);

            if ($oSalaryOfAttendance) {               
                $oSalaryOfAttendance->delete();
                return $this->sendResponse($oSalaryOfAttendance, $this->successStatus);
            }else{
                return $this->sendError(404, ['error'=> 'Salary Of Attendance does not exist.']);
            }
        }catch (\Exception $e){
            return $this->sendError(500, ['error'=> $e]);
        }
    }
}
