<?php

namespace App\Http\Controllers\API;

use App\Model\Tenant\PositionHistory;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\PositionHistory\StoreRequest;
use App\Http\Requests\PositionHistory\UpdateRequest;

class PositionHistoryController extends Controller
{
    public function index(){
        try{
            $lsPositionHistory = PositionHistory::all();
            
            return $this->sendResponse($lsPositionHistory, $this->successStatus);
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
                    
                    $lsPositionHistory = PositionHistory::where('employee_id', '=', ''.$employeeId.'')
                        ->where(function ($query) use($filter) {
                            $query->where('old_position', 'like', '%' . $filter . '%')
                            ->orWhere('new_position', 'like', '%' . $filter . '%')
                            ->orWhere('promotion_date', 'like', '%' . $filter . '%')
                            ->orWhere('old_position_duration', 'like', '%' . $filter . '%')
                            ->orWhere('description', 'like', '%' . $filter . '%');                           
                        })->paginate($count);
                                
                }else{
                    $lsPositionHistory = PositionHistory::where('employee_id', '=', ''.$employeeId.'')->paginate($count);
                }
    
                return $this->sendResponse($lsPositionHistory, $this->successStatus);
            }catch (\Exception $e){
                return $this->sendError(500, ['error'=> $e]);
            }
        }else{
            return $this->sendError(404, ['error'=> 'employee_id is required']);
        }
        
    }

    public function show($id){
        try{
            $oPositionHistory = PositionHistory::find($id);

            if ($oPositionHistory) {
                return $this->sendResponse($oPositionHistory, $this->successStatus);
            }else{
                return $this->sendError(404, ['error'=> 'Position History does not exist.']);
            }
        }catch (\Exception $e){
            return $this->sendError(500, ['error'=> $e]);
        }
    }

    public function store(StoreRequest $request){
        try{
            $oPositionHistory = new PositionHistory();
            $oPositionHistory->employee_id = $request->employee_id;
            $oPositionHistory->old_position = $request->old_position;
            $oPositionHistory->new_position = $request->new_position;
            $oPositionHistory->promotion_date = $request->promotion_date;
            $oPositionHistory->old_position_duration = $request->old_position_duration;
            $oPositionHistory->description = $request->description;       
            $oPositionHistory->save();
            return $this->sendResponse($oPositionHistory, $this->successStatus);
        }catch (\Exception $e){
            return $this->sendError(500, ['error'=> $e]);
        }
    }

    public function update(UpdateRequest $request,$id){
        try{
            $oPositionHistory = PositionHistory::find($id);

            if ($oPositionHistory) {
                
                $oPositionHistory->employee_id = $request->employee_id;
                $oPositionHistory->old_position = $request->old_position;
                $oPositionHistory->new_position = $request->new_position;
                $oPositionHistory->promotion_date = $request->promotion_date;
                $oPositionHistory->old_position_duration = $request->old_position_duration;
                $oPositionHistory->description = $request->description;       
                $oPositionHistory->save();
                
                return $this->sendResponse($oPositionHistory, $this->successStatus);
            }else{
                return $this->sendError(404, ['error'=> 'Position History does not exist.']);
            }
        }catch (\Exception $e){
            return $this->sendError(500, ['error'=> $e]);
        }
    }

    public function destroy($id){
        try{
            $oPositionHistory = PositionHistory::find($id);

            if ($oPositionHistory) {               
                $oPositionHistory->delete();
                return $this->sendResponse($oPositionHistory, $this->successStatus);
            }else{
                return $this->sendError(404, ['error'=> 'Position History does not exist.']);
            }
        }catch (\Exception $e){
            return $this->sendError(500, ['error'=> $e]);
        }
    }
}
