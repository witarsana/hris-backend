<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Model\Tenant\PtkpStatus;
use Illuminate\Http\Request;
use App\Http\Requests\PtkpStatus\StoreRequest;
use App\Http\Requests\PtkpStatus\UpdateRequest;
use Ramsey\Uuid\Uuid;


class PtkpStatusController extends Controller
{
    public function index(){
        try{
            $ptkpStatus = PtkpStatus::all();
            
            return $this->sendResponse($ptkpStatus, $this->successStatus);
        }catch (\Exception $e){
            return $this->sendError(500, ['error'=> $e]);
        }
    }

    public function listFilterAndPagine(Request $request){
        $filter = $request->filter;
        $count = $request->count;
        try{
            if (strlen($filter)>0){
                $ptkpStatus = PtkpStatus::where('description', 'like', '%' . $filter . '%')
                            ->orWhere('ptkp_code', 'like', '%' . $filter . '%')
                            ->orWhere('status', 'like', '%' . $filter . '%')
                            ->orWhere('dependents', 'like', '%' . $filter . '%')
                            ->orWhere('ptkp_value', 'like', '%' . $filter . '%')
                            ->paginate($count);
            }else{
                $ptkpStatus = PtkpStatus::paginate($count);
            }
            
            
            return $this->sendResponse($ptkpStatus, $this->successStatus);
        }catch (\Exception $e){
            return $this->sendError(500, ['error'=> $e]);
        }
    }

    public function show($id){
        try{
            $oPktpStatus = PtkpStatus::find($id);

            if ($oPktpStatus) {
                return $this->sendResponse($oPktpStatus, $this->successStatus);
            }else{
                return $this->sendError(404, ['error'=> 'PTKP Status does not exist.']);
            }
        }catch (\Exception $e){
            return $this->sendError(500, ['error'=> $e]);
        }
    }

    public function store(StoreRequest $request){
        
        
        try{
            $oPktpStatus = new PtkpStatus();
            $oPktpStatus->ptkp_code = Uuid::uuid4()->getHex();
            $oPktpStatus->description = $request->description;
            $oPktpStatus->status = $request->status;
            $oPktpStatus->dependents = $request->dependents;
            $oPktpStatus->ptkp_value = $request->ptkp_value;
            $oPktpStatus->save();
            return $this->sendResponse($oPktpStatus, $this->successStatus);
        }catch (\Exception $e){
            return $this->sendError(500, ['error'=> $e]);
        }
        

    }

    public function update(UpdateRequest $request,$id){
        try{
            $oPktpStatus = PtkpStatus::find($id);

            if ($oPktpStatus) {
                $oPktpStatus->description = $request->description;
                $oPktpStatus->status = $request->status;
                $oPktpStatus->dependents = $request->dependents;
                $oPktpStatus->ptkp_value = $request->ptkp_value;
                $oPktpStatus->save();
                return $this->sendResponse($oPktpStatus, $this->successStatus);
            }else{
                return $this->sendError(404, ['error'=> 'PTKP Status does not exist.']);
            }
        }catch (\Exception $e){
            return $this->sendError(500, ['error'=> $e]);
        }
    }

    public function destroy($id){
        try{
            $oPktpStatus = PtkpStatus::find($id);

            if ($oPktpStatus) {               
                $oPktpStatus->delete();
                return $this->sendResponse($oPktpStatus, $this->successStatus);
            }else{
                return $this->sendError(404, ['error'=> 'PTKP Status does not exist.']);
            }
        }catch (\Exception $e){
            return $this->sendError(500, ['error'=> $e]);
        }
    }


}
