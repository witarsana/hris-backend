<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Tenant\WorkshiftChange;
use App\Http\Requests\WorkshiftChange\StoreRequest;
use App\Http\Requests\WorkshiftChange\UpdateRequest;

class WorkshiftChangeController extends Controller
{
    public function index(){
        try{
            $lsWorkshiftChange = WorkshiftChange::with('pegawai','user_i','user_e')->get();            
            return $this->sendResponse($lsWorkshiftChange, $this->successStatus);
        }catch (\Exception $e){
            return $this->sendError(500, ['error'=> $e]);
        }
    
    }

    public function show($id){
        try{
            $oWorkshiftChange = WorkshiftChange::with('pegawai','user_i','user_e')->find($id);

            if ($oWorkshiftChange) {
                return $this->sendResponse($oWorkshiftChange, $this->successStatus);
            }else{
                return $this->sendError(404, ['error'=> 'Workshift Change does not exist.']);
            }
        }catch (\Exception $e){
            return $this->sendError(500, ['error'=> $e]);
        }
    }

    public function listFilterAndPagine(Request $request){
        $filter = $request->filter;
        $count = $request->count;
        try{
            if (strlen($filter)>0){
                $lsWorkshiftChange = WorkshiftChange::with('pegawai','user_i','user_e')
                    ->whereHas('pegawai', function ($query) use($filter) {
                        $query->where('first_name', 'like', '%' . $filter . '%')
                        ->orWhere('middle_name', 'like', '%' . $filter . '%')
                        ->orWhere('last_name', 'like', '%' . $filter . '%');
                    })
                    ->orWhere('employee_id', 'like', '%' . $filter . '%')
                    ->orWhere('date', 'like', '%' . $filter . '%')
                    ->orWhere('shift_code', 'like', '%' . $filter . '%')
                    ->orWhere('shift_code', 'like', '%' . $filter . '%')
                    ->orWhere('description', 'like', '%' . $filter . '%')
                    ->paginate($count);
            }else{
                $lsWorkshiftChange = WorkshiftChange::with('pegawai','user_i','user_e')->paginate($count);
            }
            
            
            return $this->sendResponse($lsWorkshiftChange, $this->successStatus);
        }catch (\Exception $e){
            return $this->sendError(500, ['error'=> $e]);
        }
    }

    public function store(StoreRequest $request){
        try{
            $oWorkshiftChange = new WorkshiftChange();
            $oWorkshiftChange->employee_id = $request->employee_id;
            $oWorkshiftChange->date = $request->date;
            $oWorkshiftChange->shift_code = $request->shift_code;
            $oWorkshiftChange->description = $request->description;
            $oWorkshiftChange->user_input = $request->get('userLoginId');
            $oWorkshiftChange->user_edit = $request->get('userLoginId');
            $oWorkshiftChange->save();
            return $this->sendResponse($oWorkshiftChange, $this->successStatus);
        }catch (\Exception $e){
            return $this->sendError(500, ['error'=> $e]);
        }
    }

    public function update(UpdateRequest $request,$id){
        try{
            $oWorkshiftChange = WorkshiftChange::find($id);

            if ($oWorkshiftChange) {
                $oWorkshiftChange->employee_id = $request->employee_id;
                $oWorkshiftChange->date = $request->date;
                $oWorkshiftChange->shift_code = $request->shift_code;
                $oWorkshiftChange->description = $request->description;
                $oWorkshiftChange->user_input = $request->get('userLoginId');
                $oWorkshiftChange->save();
                return $this->sendResponse($oWorkshiftChange, $this->successStatus);
            }else{
                return $this->sendError(404, ['error'=> 'Workshift Change does not exist.']);
            }
        }catch (\Exception $e){
            return $this->sendError(500, ['error'=> $e]);
        }
    }

    public function destroy($id){
        try{
            $oWorkshiftChange = WorkshiftChange::find($id);

            if ($oWorkshiftChange) {               
                $oWorkshiftChange->delete();
                return $this->sendResponse($oWorkshiftChange, $this->successStatus);
            }else{
                return $this->sendError(404, ['error'=> 'Workshift Change does not exist.']);
            }
        }catch (\Exception $e){
            return $this->sendError(500, ['error'=> $e]);
        }
    }
}
