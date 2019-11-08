<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Tenant\Attendance;
use App\Http\Requests\Attendance\StoreRequest;
use App\Http\Requests\Attendance\UpdateRequest;

class AttendanceController extends Controller
{
    public function index(){
        try{
            $lsAttendance = Attendance::with('pegawai','user_i','user_e')->get();            
            return $this->sendResponse($lsAttendance, $this->successStatus);
        }catch (\Exception $e){
            return $this->sendError(500, ['error'=> $e]);
        }
    
    }

    public function listFilterAndPagine(Request $request){
        $filter = $request->filter;
        $count = $request->count;
        try{
            if (strlen($filter)>0){
                $lsAttendance = Attendance::with('pegawai','user_i','user_e')
                    ->whereHas('pegawai', function ($query) use($filter) {
                        $query->where('first_name', 'like', '%' . $filter . '%')
                        ->orWhere('middle_name', 'like', '%' . $filter . '%')
                        ->orWhere('last_name', 'like', '%' . $filter . '%');
                    })
                    ->orWhere('employee_id', 'like', '%' . $filter . '%')
                    ->orWhere('date', 'like', '%' . $filter . '%')
                    ->orWhere('time_in', 'like', '%' . $filter . '%')
                    ->orWhere('time_out', 'like', '%' . $filter . '%')
                    ->orWhere('shift_code', 'like', '%' . $filter . '%')
                    ->orWhere('total_work_hour', 'like', '%' . $filter . '%')
                    ->orWhere('day_type', 'like', '%' . $filter . '%')
                    ->orWhere('overtime_value_by_SPL', 'like', '%' . $filter . '%')
                    ->orWhere('overtime_value_by_att', 'like', '%' . $filter . '%')
                    ->orWhere('overtime_value_by_approval', 'like', '%' . $filter . '%')
                    ->orWhere('overtime_value_conversion', 'like', '%' . $filter . '%')
                    ->orWhere('late_status', 'like', '%' . $filter . '%')
                    ->orWhere('late_minutes', 'like', '%' . $filter . '%')
                    ->orWhere('early_out_status', 'like', '%' . $filter . '%')
                    ->orWhere('early_out_minutes', 'like', '%' . $filter . '%')
                    ->orWhere('description', 'like', '%' . $filter . '%')
                    ->paginate($count);
            }else{
                $lsAttendance = Attendance::with('pegawai','user_i','user_e')->paginate($count);
            }
            
            
            return $this->sendResponse($lsAttendance, $this->successStatus);
        }catch (\Exception $e){
            return $this->sendError(500, ['error'=> $e]);
        }
    }

    public function store(StoreRequest $request){
        try{
            $oAttendance = new Attendance();
            $oAttendance->employee_id = $request->employee_id;
            $oAttendance->date = $request->date;
            $oAttendance->time_in = $request->time_in;
            $oAttendance->time_out = $request->time_out;
            $oAttendance->shift_code = $request->shift_code;
            $oAttendance->total_work_hour = $request->total_work_hour;
            $oAttendance->day_type = $request->day_type;
            $oAttendance->overtime_value_by_SPL = $request->overtime_value_by_SPL;
            $oAttendance->overtime_value_by_att = $request->overtime_value_by_att;
            $oAttendance->overtime_value_by_approval = $request->overtime_value_by_approval;
            $oAttendance->overtime_value_conversion = $request->overtime_value_conversion;
            $oAttendance->late_status = $request->late_status;
            $oAttendance->late_minutes = $request->late_minutes;
            $oAttendance->early_out_status = $request->early_out_status;
            $oAttendance->early_out_minutes = $request->early_out_minutes;
            $oAttendance->description = $request->description;
            $oAttendance->user_input = $request->get('userLoginId');
            $oAttendance->user_edit = $request->get('userLoginId');
            $oAttendance->save();
            return $this->sendResponse($oAttendance, $this->successStatus);
        }catch (\Exception $e){
            return $this->sendError(500, ['error'=> $e]);
        }
    }

    public function update(UpdateRequest $request,$id){
        try{
            $oAttendance = Attendance::find($id);

            if ($oAttendance) {
                $oAttendance->employee_id = $request->employee_id;
                $oAttendance->date = $request->date;
                $oAttendance->time_in = $request->time_in;
                $oAttendance->time_out = $request->time_out;
                $oAttendance->shift_code = $request->shift_code;
                $oAttendance->total_work_hour = $request->total_work_hour;
                $oAttendance->day_type = $request->day_type;
                $oAttendance->overtime_value_by_SPL = $request->overtime_value_by_SPL;
                $oAttendance->overtime_value_by_att = $request->overtime_value_by_att;
                $oAttendance->overtime_value_by_approval = $request->overtime_value_by_approval;
                $oAttendance->overtime_value_conversion = $request->overtime_value_conversion;
                $oAttendance->late_status = $request->late_status;
                $oAttendance->late_minutes = $request->late_minutes;
                $oAttendance->early_out_status = $request->early_out_status;
                $oAttendance->early_out_minutes = $request->early_out_minutes;
                $oAttendance->description = $request->description;
                $oAttendance->user_edit = $request->get('userLoginId');
                $oAttendance->save();
                return $this->sendResponse($oAttendance, $this->successStatus);
            }else{
                return $this->sendError(404, ['error'=> 'Attendance does not exist.']);
            }
        }catch (\Exception $e){
            return $this->sendError(500, ['error'=> $e]);
        }
    }

    public function destroy($id){
        try{
            $oAttendance = Attendance::find($id);

            if ($oAttendance) {               
                $oAttendance->delete();
                return $this->sendResponse($oAttendance, $this->successStatus);
            }else{
                return $this->sendError(404, ['error'=> 'Attendance does not exist.']);
            }
        }catch (\Exception $e){
            return $this->sendError(500, ['error'=> $e]);
        }
    }
}
