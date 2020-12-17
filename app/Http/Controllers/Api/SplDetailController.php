<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Tenant\SplDetail;
use App\Http\Requests\SplDetail\StoreRequest;
use App\Http\Requests\SplDetail\UpdateRequest;

class SplDetailController extends Controller
{
    public function index(){
        try{
            $lsSplDetail = SplDetail::with('pegawai','user_i','user_e')->get();            
            return $this->sendResponse($lsSplDetail, $this->successStatus);
        }catch (\Exception $e){
            return $this->sendError(500, ['error'=> $e]);
        }
    
    }

    public function show($id){
        try{
            $oSplDetail = SplDetail::with('pegawai','user_i','user_e')->find($id);

            if ($oSplDetail) {
                return $this->sendResponse($oSplDetail, $this->successStatus);
            }else{
                return $this->sendError(404, ['error'=> 'Spl Detail does not exist.']);
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
                $lsSplDetail = SplDetail::with('pegawai','user_i','user_e')
                    ->whereHas('pegawai', function ($query) use($filter) {
                        $query->where('first_name', 'like', '%' . $filter . '%')
                        ->orWhere('middle_name', 'like', '%' . $filter . '%')
                        ->orWhere('last_name', 'like', '%' . $filter . '%');
                    })
                    ->orWhere('overtime_hour', 'like', '%' . $filter . '%')
                    ->orWhere('overtime_hour_real', 'like', '%' . $filter . '%')
                    ->paginate($count);
            }else{
                $lsSplDetail = SplDetail::with('pegawai','user_i','user_e')->paginate($count);
            }
            
            
            return $this->sendResponse($lsSplDetail, $this->successStatus);
        }catch (\Exception $e){
            return $this->sendError(500, ['error'=> $e]);
        }
    }

    public function store(StoreRequest $request){
        try{
            $oSplDetail = new SplDetail();
            $oSplDetail->spl_number = $request->spl_number;
            $oSplDetail->employee_id = $request->employee_id;
            $oSplDetail->overtime_hour = $request->overtime_hour;
            $oSplDetail->overtime_hour_real = $request->overtime_hour_real;
            $oSplDetail->user_input = $request->get('userLoginId');
            $oSplDetail->user_edit = $request->get('userLoginId');
            $oSplDetail->save();
            return $this->sendResponse($oSplDetail, $this->successStatus);
        }catch (\Exception $e){
            return $this->sendError(500, ['error'=> $e]);
        }
    }

    public function update(UpdateRequest $request,$id){
        try{
            $oSplDetail = SplDetail::find($id);

            if ($oSplDetail) {
                $oSplDetail->spl_number = $request->spl_number;
                $oSplDetail->employee_id = $request->employee_id;
                $oSplDetail->overtime_hour = $request->overtime_hour;
                $oSplDetail->overtime_hour_real = $request->overtime_hour_real;
                $oSplDetail->user_edit = $request->get('userLoginId');
                $oSplDetail->save();
                return $this->sendResponse($oSplDetail, $this->successStatus);
            }else{
                return $this->sendError(404, ['error'=> 'SPL Detail does not exist.']);
            }
        }catch (\Exception $e){
            return $this->sendError(500, ['error'=> $e]);
        }
    }

    public function destroy($id){
        try{
            $oSplDetail = SplDetail::find($id);

            if ($oSplDetail) {               
                $oSplDetail->delete();
                return $this->sendResponse($oSplDetail, $this->successStatus);
            }else{
                return $this->sendError(404, ['error'=> 'Spl Detail does not exist.']);
            }
        }catch (\Exception $e){
            return $this->sendError(500, ['error'=> $e]);
        }
    }
}
