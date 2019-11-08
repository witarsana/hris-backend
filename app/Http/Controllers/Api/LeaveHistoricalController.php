<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Tenant\LeaveHistorical;
use App\Http\Requests\LeaveHistorical\StoreRequest;
use App\Http\Requests\LeaveHistorical\UpdateRequest;
use App\Http\Requests\LeaveHistorical\ApproveRequest;
use DateTime;

class LeaveHistoricalController extends Controller
{
    public function index(){
        try {
            $lsLeaveHistorical = LeaveHistorical::with('user_i','user_e','delegation','approved')->get();            
            return $this->sendResponse($lsLeaveHistorical, $this->successStatus);
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
                    
                    $lsLeaveHistorical = LeaveHistorical::with('user_i','user_e','delegation','approved')
                        ->where('employee_id', '=', ''.$employeeId.'')
                        ->where(function ($query) use($filter) {
                            $query->where('start_date', 'like', '%' . $filter . '%')                   
                            ->orWhere('end_date', 'like', '%' . $filter . '%')
                            ->orWhere('leave_amount_days', 'like', '%' . $filter . '%')
                            ->orWhere('leave_type', 'like', '%' . $filter . '%')
                            ->orWhere('description', 'like', '%' . $filter . '%')
                            ->orWhere('outside_city_status', 'like', '%' . $filter . '%')
                            ->orWhere('emergency_number', 'like', '%' . $filter . '%');                          
                        })->paginate($count);
                                
                }else{
                    $lsLeaveHistorical = LeaveHistorical::with('user_input','user_edit','delegation','approved')->paginate($count);
                }
    
                return $this->sendResponse($lsLeaveHistorical, $this->successStatus);
            }catch (\Exception $e){
                return $this->sendError(500, ['error'=> $e]);
            }
        }else{
            return $this->sendError(404, ['error'=> 'employee_id is required']);
        }      
    }

    public function show($id){
        try{
            $oLeaveHistorical = LeaveHistorical::with('user_i','user_e','delegation','approved')->find($id);

            if ($oLeaveHistorical) {
                return $this->sendResponse($oLeaveHistorical, $this->successStatus);
            }else{
                return $this->sendError(404, ['error'=> 'Leave Historical does not exist.']);
            }
            
            return $this->sendResponse($oLeaveHistorical, $this->successStatus);
        }catch (\Exception $e){
            return $this->sendError(500, ['error'=> $e]);
        }
    }

    public function store(StoreRequest $request){
        try {
            $oLeaveHistorical = new LeaveHistorical();
            $oLeaveHistorical->employee_id = $request->employee_id; 
            $oLeaveHistorical->start_date = $request->start_date;
            $oLeaveHistorical->end_date = $request->end_date;
            $oLeaveHistorical->leave_amount_days = $request->leave_amount_days;           
            $oLeaveHistorical->leave_type = $request->leave_type;
            $oLeaveHistorical->description = $request->description;
            $oLeaveHistorical->outside_city_status = $request->outside_city_status;
            $oLeaveHistorical->emergency_number = $request->emergency_number;
            $oLeaveHistorical->delegation_job_to = $request->delegation_job_to;
            $oLeaveHistorical->approved_by = $request->approved_by;
            $oLeaveHistorical->approved_date = $request->approved_date;          
            $oLeaveHistorical->user_input = $request->get('userLoginId'); 
            $oLeaveHistorical->user_edit = $request->get('userLoginId'); 
            $oLeaveHistorical->save();
            return $this->sendResponse($oLeaveHistorical, $this->successStatus);
        } catch (\Exception $e) {
            return $this->sendError(500, ['error'=> $e]);
        }
    }

    public function update(UpdateRequest $request,$id){
        try{
            $oLeaveHistorical = LeaveHistorical::find($id);

            if ($oLeaveHistorical) {
                $oLeaveHistorical->employee_id = $request->employee_id; 
                $oLeaveHistorical->start_date = $request->start_date;
                $oLeaveHistorical->end_date = $request->end_date;
                $oLeaveHistorical->leave_amount_days = $request->leave_amount_days;           
                $oLeaveHistorical->leave_type = $request->leave_type;
                $oLeaveHistorical->description = $request->description;
                $oLeaveHistorical->outside_city_status = $request->outside_city_status;
                $oLeaveHistorical->emergency_number = $request->emergency_number;
                $oLeaveHistorical->delegation_job_to = $request->delegation_job_to;
                $oLeaveHistorical->approved_by = $request->approved_by;
                $oLeaveHistorical->approved_date = $request->approved_date;           
                $oLeaveHistorical->user_edit = $request->get('userLoginId'); 
                $oLeaveHistorical->save();
                return $this->sendResponse($oLeaveHistorical, $this->successStatus);
            }else{
                return $this->sendError(404, ['error'=> 'Leave Historical does not exist.']);
            }
        }catch (\Exception $e){
            return $this->sendError(500, ['error'=> $e]);
        }
    }

    public function approve(ApproveRequest $request,$id){
        try{
            $oLeaveHistorical = LeaveHistorical::find($id);

            if ($oLeaveHistorical) {               
                $oLeaveHistorical->approved_by = $request->approved_by;
                $oLeaveHistorical->approved_date = $request->approved_date;           
                $oLeaveHistorical->user_edit = $request->get('userLoginId'); 
                $oLeaveHistorical->save();
                return $this->sendResponse($oLeaveHistorical, $this->successStatus);
            }else{
                return $this->sendError(404, ['error'=> 'Leave Historical does not exist.']);
            }
        }catch (\Exception $e){
            return $this->sendError(500, ['error'=> $e]);
        }
    }

    public function destroy($id){
        try {
            $oLeaveHistorical = LeaveHistorical::find($id);
            if ($oLeaveHistorical) {
                $oLeaveHistorical->delete();
                return $this->sendResponse($oLeaveHistorical, $this->successStatus);
            }else{
                return $this->sendError(404, ['error'=> 'Leave Historical does not exist.']);
            }
        } catch (\Exception $e) {
            return $this->sendError(500, ['error'=> $e]);
        
        }
    }
}
