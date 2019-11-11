<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Model\Tenant\TrainingHistorical;
use Illuminate\Http\Request;
use App\Http\Requests\TrainingHistorical\StoreRequest;
use App\Http\Requests\TrainingHistorical\UpdateRequest;

class TrainingHistoricalController extends Controller
{
    public function index(){
        try{
            $lsTrainingHistorical = TrainingHistorical::with('training_type','user_i','user_e')->get();            
            return $this->sendResponse($lsTrainingHistorical, $this->successStatus);
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
                    
                    $lsTrainingHistorical = TrainingHistorical::with('training_type','user_i','user_e')
                        ->where('employee_id', '=', ''.$employeeId.'')
                        ->where(function ($query) use($filter) {
                            $query->where('training_name', 'like', '%' . $filter . '%')
                            ->orWhere('organizer', 'like', '%' . $filter . '%')
                            ->orWhere('trainer_name', 'like', '%' . $filter . '%')
                            ->orWhere('instructor', 'like', '%' . $filter . '%')
                            ->orWhere('certification_type', 'like', '%' . $filter . '%')
                            ->orWhere('start_date', 'like', '%' . $filter . '%')
                            ->orWhere('end_date', 'like', '%' . $filter . '%')
                            ->orWhere('pre_test_score', 'like', '%' . $filter . '%')
                            ->orWhere('post_test_score', 'like', '%' . $filter . '%')
                            ->orWhere('standard_score', 'like', '%' . $filter . '%')
                            ->orWhere('evaluation', 'like', '%' . $filter . '%')
                            ->orWhere('description', 'like', '%' . $filter . '%')
                            ->orWhere('certificate_number', 'like', '%' . $filter . '%');
                            
                        })->paginate($count);
                                
                }else{
                    $lsTrainingHistorical = TrainingHistorical::with('training_type','user_i','user_e')->paginate($count);
                }
    
                return $this->sendResponse($lsTrainingHistorical, $this->successStatus);
            }catch (\Exception $e){
                return $this->sendError(500, ['error'=> $e]);
            }
        }else{
            return $this->sendError(404, ['error'=> 'employee_id is required']);
        }      
    }

    public function show($id){
        try{
            $oTrainingHistorical = TrainingHistorical::with('training_type','user_i','user_e')->find($id);

            if ($oTrainingHistorical) {
                return $this->sendResponse($oTrainingHistorical, $this->successStatus);
            }else{
                return $this->sendError(404, ['error'=> 'Training Historical does not exist.']);
            }
        }catch (\Exception $e){
            return $this->sendError(500, ['error'=> $e]);
        }
    }

    public function store(StoreRequest $request){
        try{
            $oTrainingHistorical = new TrainingHistorical();
            $oTrainingHistorical->employee_id = $request->employee_id;
            $oTrainingHistorical->training_name = $request->training_name;
            $oTrainingHistorical->organizer = $request->organizer;
            $oTrainingHistorical->trainer_name = $request->trainer_name;
            $oTrainingHistorical->instructor = $request->instructor;
            $oTrainingHistorical->certification_type = $request->certification_type;
            $oTrainingHistorical->start_date = $request->start_date;
            $oTrainingHistorical->end_date = $request->end_date;
            $oTrainingHistorical->pre_test_score = $request->pre_test_score;
            $oTrainingHistorical->post_test_score = $request->post_test_score;
            $oTrainingHistorical->standard_score = $request->standard_score;
            $oTrainingHistorical->evaluation = $request->evaluation;
            $oTrainingHistorical->description = $request->description;
            $oTrainingHistorical->certificate_number = $request->certificate_number;
            $oTrainingHistorical->training_type_code = $request->training_type_code;
            $oTrainingHistorical->user_input = $request->get('userLoginId');
            $oTrainingHistorical->user_edit = $request->get('userLoginId');
            $oTrainingHistorical->save();
            return $this->sendResponse($oTrainingHistorical, $this->successStatus);
        }catch (\Exception $e){
            return $this->sendError(500, ['error'=> $e]);
        }
    }

    public function update(UpdateRequest $request,$id){
        try{
            $oTrainingHistorical = TrainingHistorical::find($id);

            if ($oTrainingHistorical) {
                $oTrainingHistorical->employee_id = $request->employee_id;
                $oTrainingHistorical->training_name = $request->training_name;
                $oTrainingHistorical->organizer = $request->organizer;
                $oTrainingHistorical->trainer_name = $request->trainer_name;
                $oTrainingHistorical->instructor = $request->instructor;
                $oTrainingHistorical->certification_type = $request->certification_type;
                $oTrainingHistorical->start_date = $request->start_date;
                $oTrainingHistorical->end_date = $request->end_date;
                $oTrainingHistorical->pre_test_score = $request->pre_test_score;
                $oTrainingHistorical->post_test_score = $request->post_test_score;
                $oTrainingHistorical->standard_score = $request->standard_score;
                $oTrainingHistorical->evaluation = $request->evaluation;
                $oTrainingHistorical->description = $request->description;
                $oTrainingHistorical->certificate_number = $request->certificate_number;
                $oTrainingHistorical->training_type_code = $request->training_type_code;
                $oTrainingHistorical->user_edit = $request->get('userLoginId');               
                $oTrainingHistorical->save();
                return $this->sendResponse($oTrainingHistorical, $this->successStatus);
            }else{
                return $this->sendError(404, ['error'=> 'Training Historical does not exist.']);
            }
        }catch (\Exception $e){
            return $this->sendError(500, ['error'=> $e]);
        }
    }

    public function destroy($id){
        try{
            $oTrainingHistorical = TrainingHistorical::find($id);

            if ($oTrainingHistorical) {               
                $oTrainingHistorical->delete();
                return $this->sendResponse($oTrainingHistorical, $this->successStatus);
            }else{
                return $this->sendError(404, ['error'=> 'Training Historical does not exist.']);
            }
        }catch (\Exception $e){
            return $this->sendError(500, ['error'=> $e]);
        }
    }
}
