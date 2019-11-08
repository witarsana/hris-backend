<?php

namespace App\Http\Controllers\Api;

use App\Model\Tenant\Education;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Education\StoreRequest;
use App\Http\Requests\Education\UpdateRequest;
use Illuminate\Database\QueryException;

class EducationController extends Controller
{
    public function index(){
        
        try{
            $lsEducation = Education::all();            
            return $this->sendResponse($lsEducation, $this->successStatus);
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
                    
                    $lsEducation = Education::where('employee_id', '=', ''.$employeeId.'')
                        ->where(function ($query) use($filter) {
                            $query->where('grade', 'like', '%' . $filter . '%')
                            ->orWhere('education_name', 'like', '%' . $filter . '%')
                            ->orWhere('location', 'like', '%' . $filter . '%')
                            ->orWhere('education_duration', 'like', '%' . $filter . '%')
                            ->orWhere('graduate_year', 'like', '%' . $filter . '%')
                            ->orWhere('description', 'like', '%' . $filter . '%')
                            ->orWhere('last_education_status', 'like', '%' . $filter . '%');
                        })->paginate($count);
                                
                }else{
                    $lsEducation = Education::where('employee_id', '=', ''.$employeeId.'')->paginate($count);
                }
    
                return $this->sendResponse($lsEducation, $this->successStatus);
            }catch (\Exception $e){
                return $this->sendError(500, ['error'=> $e]);
            }
        }else{
            return $this->sendError(404, ['error'=> 'employee_id is required']);
        }
        
    }

    public function show($id){
        try{
            $oEducation = Education::find($id);

            if ($oEducation) {
                return $this->sendResponse($oEducation, $this->successStatus);
            }else{
                return $this->sendError(404, ['error'=> 'Education does not exist.']);
            }
        }catch (\Exception $e){
            return $this->sendError(500, ['error'=> $e]);
        }
    }

    public function store(StoreRequest $request){
        try{
            $oEducation = new Education();
            $oEducation->employee_id = $request->employee_id;
            $oEducation->grade = $request->grade;
            $oEducation->education_name = $request->education_name;
            $oEducation->location = $request->location;
            $oEducation->education_duration = $request->education_duration;
            $oEducation->graduate_year = $request->graduate_year;
            $oEducation->description = $request->description;
            $oEducation->last_education_status = $request->last_education_status;
            $oEducation->save();
            return $this->sendResponse($oEducation, $this->successStatus);
        }catch (\Exception $e){
            return $this->sendError(500, ['error'=> $e]);
        }
    }

    public function update(UpdateRequest $request,$id){
        try{
            $oEducation = Education::find($id);

            if ($oEducation) {
                $oEducation->employee_id = $request->employee_id;
                $oEducation->grade = $request->grade;
                $oEducation->education_name = $request->education_name;
                $oEducation->location = $request->location;
                $oEducation->education_duration = $request->education_duration;
                $oEducation->graduate_year = $request->graduate_year;
                $oEducation->description = $request->description;
                $oEducation->last_education_status = $request->last_education_status;
                $oEducation->save();
                return $this->sendResponse($oEducation, $this->successStatus);
            }else{
                return $this->sendError(404, ['error'=> 'Education does not exist.']);
            }
        }catch (\Exception $e){
            return $this->sendError(500, ['error'=> $e]);
        }
    }

    public function destroy($id){
        try{
            $oEducation = Education::find($id);

            if ($oEducation) {               
                $oEducation->delete();
                return $this->sendResponse($oEducation, $this->successStatus);
            }else{
                return $this->sendError(404, ['error'=> 'Education does not exist.']);
            }
        }catch (\Exception $e){
            return $this->sendError(500, ['error'=> $e]);
        }
    }
}
