<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Tenant\SettingDetail;
use App\Http\Requests\SettingDetail\StoreRequest;
use App\Http\Requests\SettingDetail\UpdateRequest;

class SettingDetailController extends Controller
{
    public function index(){
        try {
            $lsSettingDetail = SettingDetail::with('modul')->get();            
            return $this->sendResponse($lsSettingDetail, $this->successStatus);
        } catch (\Exception $e) {
            return $this->sendError(500, ['error'=> $e]);
        }
    }

    public function listFilterAndPagine(Request $request){
        $filter = $request->filter;
        $count = $request->count;
        try{
            if (strlen($filter)>0){
                $lsSettingDetail = SettingDetail::with('modul')
                    ->where('setting_name', 'like', '%' . $filter . '%')
                    ->orWhere('value', 'like', '%' . $filter . '%')
                    ->paginate($count);
                            
            }else{
                $lsSettingDetail = SettingDetail::with('modul')->paginate($count);
            }

            return $this->sendResponse($lsSettingDetail, $this->successStatus);
        }catch (\Exception $e){
            return $this->sendError(500, ['error'=> $e]);
        }
           
    }

    public function show($id){
        try{
            $oSettingDetail = SettingDetail::find($id);

            if ($oSettingDetail) {
                return $this->sendResponse($oSettingDetail, $this->successStatus);
            }else{
                return $this->sendError(404, ['error'=> 'Setting Detail does not exist.']);
            }
        }catch (\Exception $e){
            return $this->sendError(500, ['error'=> $e]);
        }
    }

    public function store(StoreRequest $request){
        try{
            $oSettingDetail = new SettingDetail();
            $oSettingDetail->modul_id = $request->modul_id;
            $oSettingDetail->setting_name = $request->setting_name;
            $oSettingDetail->value = $request->value;
            $oSettingDetail->description = $request->description;
            $oSettingDetail->save();
            return $this->sendResponse($oSettingDetail, $this->successStatus);
        }catch (\Exception $e){
            return $this->sendError(500, ['error'=> $e]);
        }
    }

    public function update(UpdateRequest $request,$id){
        try{
            $oSettingDetail = SettingDetail::find($id);

            if ($oSettingDetail) {
                $oSettingDetail->modul_id = $request->modul_id;
                $oSettingDetail->setting_name = $request->setting_name;
                $oSettingDetail->value = $request->value;
                $oSettingDetail->description = $request->description;              
                $oSettingDetail->save();
                return $this->sendResponse($oSettingDetail, $this->successStatus);
            }else{
                return $this->sendError(404, ['error'=> 'Setting Detail does not exist.']);
            }
        }catch (\Exception $e){
            return $this->sendError(500, ['error'=> $e]);
        }
    }

    public function destroy($id){
        try{
            $oSettingDetail = SettingDetail::find($id);

            if ($oSettingDetail) {               
                $oSettingDetail->delete();
                return $this->sendResponse($oSettingDetail, $this->successStatus);
            }else{
                return $this->sendError(404, ['error'=> 'Setting Detail does not exist.']);
            }
        }catch (\Exception $e){
            return $this->sendError(500, ['error'=> $e]);
        }
    }
}
