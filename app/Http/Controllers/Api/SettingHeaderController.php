<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Tenant\SettingHeader;
use App\Http\Requests\SettingHeader\StoreRequest;
use App\Http\Requests\SettingHeader\UpdateRequest;

class SettingHeaderController extends Controller
{
    public function index(){
        try {
            $lsSettingHeader = SettingHeader::all();            
            return $this->sendResponse($lsSettingHeader, $this->successStatus);
        } catch (\Exception $e) {
            return $this->sendError(500, ['error'=> $e]);
        }
    }

    public function listFilterAndPagine(Request $request){
        $filter = $request->filter;
        $count = $request->count;
        try{
            if (strlen($filter)>0){
                $lsSettingHeader = SettingHeader::
                    where('modul_name', 'like', '%' . $filter . '%')
                    ->paginate($count);
                            
            }else{
                $lsSettingHeader = SettingHeader::paginate($count);
            }

            return $this->sendResponse($lsSettingHeader, $this->successStatus);
        }catch (\Exception $e){
            return $this->sendError(500, ['error'=> $e]);
        }
           
    }

    public function show($id){
        try{
            $oSettingHeader = SettingHeader::find($id);

            if ($oSettingHeader) {
                return $this->sendResponse($oSettingHeader, $this->successStatus);
            }else{
                return $this->sendError(404, ['error'=> 'Setting Header does not exist.']);
            }
        }catch (\Exception $e){
            return $this->sendError(500, ['error'=> $e]);
        }
    }

    public function store(StoreRequest $request){
        try{
            $oSettingHeader = new SettingHeader();
            $oSettingHeader->modul_name = $request->modul_name;
            $oSettingHeader->description = $request->description;
            $oSettingHeader->save();
            return $this->sendResponse($oSettingHeader, $this->successStatus);
        }catch (\Exception $e){
            return $this->sendError(500, ['error'=> $e]);
        }
    }

    public function update(UpdateRequest $request,$id){
        try{
            $oSettingHeader = SettingHeader::find($id);

            if ($oSettingHeader) {
                $oSettingHeader->modul_name = $request->modul_name;
                $oSettingHeader->description = $request->description;               
                $oSettingHeader->save();
                return $this->sendResponse($oSettingHeader, $this->successStatus);
            }else{
                return $this->sendError(404, ['error'=> 'Setting Header does not exist.']);
            }
        }catch (\Exception $e){
            return $this->sendError(500, ['error'=> $e]);
        }
    }

    public function destroy($id){
        try{
            $oSettingHeader = SettingHeader::find($id);

            if ($oSettingHeader) {               
                $oSettingHeader->delete();
                return $this->sendResponse($oSettingHeader, $this->successStatus);
            }else{
                return $this->sendError(404, ['error'=> 'Setting Header does not exist.']);
            }
        }catch (\Exception $e){
            return $this->sendError(500, ['error'=> $e]);
        }
    }
}
