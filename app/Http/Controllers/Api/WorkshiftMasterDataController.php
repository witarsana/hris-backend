<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Tenant\WorkshiftMasterData;
use App\Http\Requests\WorkshiftMasterData\StoreRequest;
use App\Http\Requests\WorkshiftMasterData\UpdateRequest;

class WorkshiftMasterDataController extends Controller
{
    public function index(){
        try{
            $lsWorkShitMasterData = WorkshiftMasterData::with('user_i','user_e')->get();            
            return $this->sendResponse($lsWorkShitMasterData, $this->successStatus);
        }catch (\Exception $e){
            return $this->sendError(500, ['error'=> $e]);
        }
    }

    public function listFilterAndPagine(Request $request){
        $filter = $request->filter;
        $count = $request->count;
        try{
            if (strlen($filter)>0){
                $lsWorkshiftMasterData = WorkshiftMasterData::with('user_i','user_e')                   
                    ->where('shift_code', 'like', '%' . $filter . '%')
                    ->orWhere('shift_name', 'like', '%' . $filter . '%')
                    ->orWhere('begin_time', 'like', '%' . $filter . '%')
                    ->orWhere('end_time', 'like', '%' . $filter . '%')
                    ->orWhere('description', 'like', '%' . $filter . '%')
                    ->paginate($count);
            }else{
                $lsWorkshiftMasterData = WorkshiftMasterData::with('user_i','user_e')->paginate($count);
            }
            
            
            return $this->sendResponse($lsWorkshiftMasterData, $this->successStatus);
        }catch (\Exception $e){
            return $this->sendError(500, ['error'=> $e]);
        }
    }

    public function show($id){
        try{
            $oWorkShiftMasterData = WorkshiftMasterData::with('user_i','user_e')->find($id);

            if ($oWorkShiftMasterData) {
                return $this->sendResponse($oWorkShiftMasterData, $this->successStatus);
            }else{
                return $this->sendError(404, ['error'=> 'Workshift Master Data does not exist.']);
            }
        }catch (\Exception $e){
            return $this->sendError(500, ['error'=> $e]);
        }
    }

    public function store(StoreRequest $request){
        try{
            $oWorkShiftMasterData = new WorkshiftMasterData();
            $oWorkShiftMasterData->shift_code = $request->shift_code;
            $oWorkShiftMasterData->shift_name = $request->shift_name;
            $oWorkShiftMasterData->begin_time = $request->begin_time;
            $oWorkShiftMasterData->end_time = $request->end_time;
            $oWorkShiftMasterData->description = $request->description;
            $oWorkShiftMasterData->user_input = $request->get('userLoginId');
            $oWorkShiftMasterData->user_edit = $request->get('userLoginId');
            $oWorkShiftMasterData->save();
            return $this->sendResponse($oWorkShiftMasterData, $this->successStatus);
        }catch (\Exception $e){
            return $this->sendError(500, ['error'=> $e]);
        }
    }

    public function update(UpdateRequest $request,$id){
        try{
            $oWorkShiftMasterData = WorkshiftMasterData::find($id);

            if ($oWorkShiftMasterData) {
                $oWorkShiftMasterData->shift_code = $request->shift_code;
                $oWorkShiftMasterData->shift_name = $request->shift_name;
                $oWorkShiftMasterData->begin_time = $request->begin_time;
                $oWorkShiftMasterData->end_time = $request->end_time;
                $oWorkShiftMasterData->description = $request->description;
                $oWorkShiftMasterData->user_edit = $request->get('userLoginId');
                $oWorkShiftMasterData->save();
                return $this->sendResponse($oWorkShiftMasterData, $this->successStatus);
            }else{
                return $this->sendError(404, ['error'=> 'Workshift Master Data does not exist.']);
            }
        }catch (\Exception $e){
            return $this->sendError(500, ['error'=> $e]);
        }
    }

    public function destroy($id){
        try{
            $oWorkShiftMasterData = WorkshiftMasterData::find($id);

            if ($oWorkShiftMasterData) {               
                $oWorkShiftMasterData->delete();
                return $this->sendResponse($oWorkShiftMasterData, $this->successStatus);
            }else{
                return $this->sendError(404, ['error'=> 'Workshift Master Data does not exist.']);
            }
        }catch (\Exception $e){
            return $this->sendError(500, ['error'=> $e]);
        }
    }
}
