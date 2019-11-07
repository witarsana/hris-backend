<?php

namespace App\Http\Controllers\API;

use App\Model\Tenant\JobHistory;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\JobHistory\StoreRequest;
use App\Http\Requests\JobHistory\UpdateRequest;
use DateTime;

class JobHistoryController extends Controller
{
    
    public function index(){
        try{
            $lsJobHistory = JobHistory::all();
            
            return $this->sendResponse($lsJobHistory, $this->successStatus);
        }catch (\Exception $e){
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
                    
                    $lsJobHistory = JobHistory::where('employee_id', '=', ''.$employeeId.'')
                        ->where(function ($query) use($filter) {
                            $query->where('company_name', 'like', '%' . $filter . '%')
                            ->orWhere('business_fields', 'like', '%' . $filter . '%')
                            ->orWhere('departement', 'like', '%' . $filter . '%')
                            ->orWhere('position', 'like', '%' . $filter . '%')
                            ->orWhere('from_date', 'like', '%' . $filter . '%')
                            ->orWhere('until_date', 'like', '%' . $filter . '%')
                            ->orWhere('description', 'like', '%' . $filter . '%')
                            ->orWhere('job_desc', 'like', '%' . $filter . '%')
                            ->orWhere('duration_of_position', 'like', '%' . $filter . '%');
                        })->paginate($count);
                                
                }else{
                    $lsJobHistory = JobHistory::where('employee_id', '=', ''.$employeeId.'')->paginate($count);
                }
    
                return $this->sendResponse($lsJobHistory, $this->successStatus);
            }catch (\Exception $e){
                return $this->sendError(500, ['error'=> $e]);
            }
        }else{
            return $this->sendError(404, ['error'=> 'employee_id is required']);
        }
        
    }

    public function show($id){
        try{
            $oJobHistory = JobHistory::find($id);

            if ($oJobHistory) {
                return $this->sendResponse($oJobHistory, $this->successStatus);
            }else{
                return $this->sendError(404, ['error'=> 'Job History does not exist.']);
            }
        }catch (\Exception $e){
            return $this->sendError(500, ['error'=> $e]);
        }
    }

    public function store(StoreRequest $request){
        try{
            $oJobHistory = new JobHistory();
            $oJobHistory->employee_id = $request->employee_id;
            $oJobHistory->company_name = $request->company_name;
            $oJobHistory->business_fields = $request->business_fields;
            $oJobHistory->departement = $request->departement;
            $oJobHistory->position = $request->position;
            $oJobHistory->from_date = $request->from_date;
            $oJobHistory->until_date = $request->until_date;
            $oJobHistory->description = $request->description;
            $oJobHistory->job_desc = $request->job_desc;

            //duration of position
            $until = new DateTime($request->until_date);
            $from = new DateTime($request->from_date);
            $interval = $until->diff($from);
            $duration = $interval->format('%y years %m months and %d days');
            $oJobHistory->duration_of_position = $duration;
            
            $oJobHistory->save();
            return $this->sendResponse($oJobHistory, $this->successStatus);
        }catch (\Exception $e){
            return $this->sendError(500, ['error'=> $e]);
        }
    }

    public function update(UpdateRequest $request,$id){
        try{
            $oJobHistory = JobHistory::find($id);

            if ($oJobHistory) {
                
                $oJobHistory->employee_id = $request->employee_id;
                $oJobHistory->company_name = $request->company_name;
                $oJobHistory->business_fields = $request->business_fields;
                $oJobHistory->departement = $request->departement;
                $oJobHistory->position = $request->position;
                $oJobHistory->from_date = $request->from_date;
                $oJobHistory->until_date = $request->until_date;
                $oJobHistory->description = $request->description;
                $oJobHistory->job_desc = $request->job_desc;

                //duration of position
                
                $until = new DateTime($request->until_date);
                $from = new DateTime($request->from_date);
                $interval = $until->diff($from);
                $duration = $interval->format('%y years %m months and %d days');
                $oJobHistory->duration_of_position = $duration;
                
                $oJobHistory->save();
                return $this->sendResponse($oJobHistory, $this->successStatus);
            }else{
                return $this->sendError(404, ['error'=> 'Job HIstory does not exist.']);
            }
        }catch (\Exception $e){
            return $this->sendError(500, ['error'=> $e]);
        }
    }

    public function destroy($id){
        try{
            $oJobHistory = JobHistory::find($id);

            if ($oJobHistory) {               
                $oJobHistory->delete();
                return $this->sendResponse($oJobHistory, $this->successStatus);
            }else{
                return $this->sendError(404, ['error'=> 'Job History does not exist.']);
            }
        }catch (\Exception $e){
            return $this->sendError(500, ['error'=> $e]);
        }
    }
    
}
