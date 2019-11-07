<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Tenant\SanctionHistorical;
use App\Http\Requests\SanctionHistorical\StoreRequest;
use App\Http\Requests\SanctionHistorical\UpdateRequest;

class SanctionHistoricalController extends Controller
{
    public function index(){
        try {
            $lsSanctionHistorical = SanctionHistorical::with('user_i','user_e')->get();            
            return $this->sendResponse($lsSanctionHistorical, $this->successStatus);
        } catch (\Exception $e) {
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
                    
                    $lsSanctionHistorical = SanctionHistorical::with('user_i','user_e')
                        ->where('employee_id', '=', ''.$employeeId.'')
                        ->where(function ($query) use($filter) {
                            $query->where('sanction_date', 'like', '%' . $filter . '%')
                            ->orWhere('sanction_begin_date', 'like', '%' . $filter . '%')
                            ->orWhere('sanction_end_date', 'like', '%' . $filter . '%')
                            ->orWhere('number_of_saction', 'like', '%' . $filter . '%')
                            ->orWhere('description', 'like', '%' . $filter . '%');                           
                        })->paginate($count);
                                
                }else{
                    $lsSanctionHistorical = SanctionHistorical::with('user_i','user_e')->paginate($count);
                }
    
                return $this->sendResponse($lsSanctionHistorical, $this->successStatus);
            }catch (\Exception $e){
                return $this->sendError(500, ['error'=> $e]);
            }
        }else{
            return $this->sendError(404, ['error'=> 'employee_id is required']);
        }      
    }

    public function show($id){
        try{
            $oSanctionHistorical = SanctionHistorical::with('user_i','user_e')->find($id);

            if ($oSanctionHistorical) {
                return $this->sendResponse($oSanctionHistorical, $this->successStatus);
            }else{
                return $this->sendError(404, ['error'=> 'Sanction Historical does not exist.']);
            }
        }catch (\Exception $e){
            return $this->sendError(500, ['error'=> $e]);
        }
    }

    public function store(StoreRequest $request){
        try {
            $oSanctionHistorical = new SanctionHistorical();
            $oSanctionHistorical->employee_id = $request->employee_id;
            $oSanctionHistorical->sanction_date = $request->sanction_date;
            $oSanctionHistorical->sanction_begin_date = $request->sanction_begin_date;
            $oSanctionHistorical->sanction_end_date = $request->sanction_end_date;
            $oSanctionHistorical->number_of_saction = $request->number_of_saction;
            $oSanctionHistorical->description = $request->description;
            $oSanctionHistorical->user_input = $request->get('userLoginId'); 
            $oSanctionHistorical->user_edit = $request->get('userLoginId'); 
            $oSanctionHistorical->save();
            return $this->sendResponse($oSanctionHistorical, $this->successStatus);
        } catch (\Exception $e) {
            return $this->sendError(500, ['error'=> $e]);
        }
    }

    public function update(UpdateRequest $request,$id){
        try{
            $oSanctionHistorical = SanctionHistorical::find($id);

            if ($oSanctionHistorical) {
                $oSanctionHistorical->employee_id = $request->employee_id;
                $oSanctionHistorical->sanction_date = $request->sanction_date;
                $oSanctionHistorical->sanction_begin_date = $request->sanction_begin_date;
                $oSanctionHistorical->sanction_end_date = $request->sanction_end_date;
                $oSanctionHistorical->number_of_saction = $request->number_of_saction;
                $oSanctionHistorical->description = $request->description; 
                $oSanctionHistorical->user_edit = $request->get('userLoginId'); 
                $oSanctionHistorical->save();
                return $this->sendResponse($oSanctionHistorical, $this->successStatus);
            }else{
                return $this->sendError(404, ['error'=> 'Sanction Historical does not exist.']);
            }
        }catch (\Exception $e){
            return $this->sendError(500, ['error'=> $e]);
        }
    }

    public function destroy($id){
        try {
            $oSanctionHistorical = SanctionHistorical::find($id);
            if ($oSanctionHistorical) {
                $oSanctionHistorical->delete();
                return $this->sendResponse($oSanctionHistorical, $this->successStatus);
            }else{
                return $this->sendError(404, ['error'=> 'Sanction Historical does not exist.']);
            }
        } catch (\Exception $e) {
            return $this->sendError(500, ['error'=> $e]);
        
        }
    }
}
