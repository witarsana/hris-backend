<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Tenant\AppraisalDetailHistorical;
use App\Model\Tenant\AppraisalHeaderHistorical;
use App\Http\Requests\AppraisalDetailHistorical\StoreRequest;
use App\Http\Requests\AppraisalDetailHistorical\UpdateRequest;
use Ramsey\Uuid\Uuid;

class AppraisalDetailHistoricalController extends Controller
{
    public function index(){
        try {
            $lsAppraisalDetailHistorical = AppraisalDetailHistorical::with('appraisal_master','user_i','user_e')->get();            
            return $this->sendResponse($lsAppraisalDetailHistorical, $this->successStatus);
        } catch (\Exception $e) {
            return $this->sendError(500, ['error'=> $e]);
        }
    }

    public function listFilterAndPagine(Request $request){
        $filter = $request->filter;
        $count = $request->count;             
        $appraisal_code = $request->appraisal_code;
        if ($appraisal_code){
            try{
                if (strlen($filter)>0){
                    
                    $lsAppraisalDetailHistorical = AppraisalDetailHistorical::with('appraisal_master','user_i','user_e')
                        ->where('appraisal_code', '=', ''.$appraisal_code.'')
                        ->where(function ($query) use($filter) {
                            $query->where('point', 'like', '%' . $filter . '%')
                            ->orWhere('appraisal_detail_code', 'like', '%' . $filter . '%');    
                        })->paginate($count);
                                
                }else{
                    $lsAppraisalDetailHistorical = AppraisalDetailHistorical::with('appraisal_master','user_i','user_e')->where('appraisal_code', '=', ''.$appraisal_code.'')->paginate($count);
                }
    
                return $this->sendResponse($lsAppraisalDetailHistorical, $this->successStatus);
            }catch (\Exception $e){
                return $this->sendError(500, ['error'=> $e]);
            }
        }else{
            return $this->sendError(404, ['error'=> 'appraisal_code is required']);
        }
             
    }

    public function show($id){
        try{
            $oAppraisalDetailHistorical = AppraisalDetailHistorical::with('user_i','user_e','appraisal_master')->find($id);

            if ($oAppraisalDetailHistorical) {
                return $this->sendResponse($oAppraisalDetailHistorical, $this->successStatus);
            }else{
                return $this->sendError(404, ['error'=> 'Appraisal Detail Historical does not exist.']);
            }
        }catch (\Exception $e){
            return $this->sendError(500, ['error'=> $e]);
        }
    }

    private function updateTotalMaster($id){

    }

    public function store(StoreRequest $request){
        try {
            $oAppraisalDetailHistorical = new AppraisalDetailHistorical();
            $oAppraisalDetailHistorical->appraisal_detail_code = $request->appraisal_detail_code;
            $oAppraisalDetailHistorical->appraisal_code = $request->appraisal_code;
            $oAppraisalDetailHistorical->point = $request->point;            
            $oAppraisalDetailHistorical->user_input = $request->get('userLoginId'); 
            $oAppraisalDetailHistorical->user_edit = $request->get('userLoginId'); 
            $oAppraisalDetailHistorical->save();

            //update total point in appraisal header historical
            $oAppraisalHeaderHistorical = $oAppraisalDetailHistorical->appraisal_header;
            $jumlah = $oAppraisalHeaderHistorical->appraisal_detail_historical()->sum("point");
            $oAppraisalHeaderHistorical->total_point =  $jumlah;
            $oAppraisalHeaderHistorical->save();

            return $this->sendResponse($oAppraisalDetailHistorical, $this->successStatus);
        } catch (\Exception $e) {
            return $this->sendError(500, ['error'=> $e]);
        }
    }

    public function update(UpdateRequest $request,$id){
        try{
            
            $oAppraisalDetailHistorical = AppraisalDetailHistorical::find($id);
            
            if ($oAppraisalDetailHistorical) {
                $oAppraisalDetailHistorical->appraisal_detail_code = $request->appraisal_detail_code;
                $oAppraisalDetailHistorical->appraisal_code = $request->appraisal_code;
                $oAppraisalDetailHistorical->point = $request->point;                      
                $oAppraisalDetailHistorical->user_edit = $request->get('userLoginId'); 
                $oAppraisalDetailHistorical->save();

                //update total point in appraisal header historical
                $oAppraisalHeaderHistorical = $oAppraisalDetailHistorical->appraisal_header;
                $jumlah = $oAppraisalHeaderHistorical->appraisal_detail_historical()->sum("point");
                $oAppraisalHeaderHistorical->total_point =  $jumlah;
                $oAppraisalHeaderHistorical->save();

                return $this->sendResponse($oAppraisalDetailHistorical, $this->successStatus);
            }else{
                return $this->sendError(404, ['error'=> 'Appraisal Detail Historical does not exist.']);
            }
        }catch (\Exception $e){
            return $this->sendError(500, ['error'=> $e]);
        }
    }

    public function destroy($id){
        try {
            $oAppraisalDetailHistorical = AppraisalDetailHistorical::find($id);
            if ($oAppraisalDetailHistorical) {
                $oAppraisalDetailHistorical->delete();

                //update total point in appraisal header historical
                $oAppraisalHeaderHistorical = $oAppraisalDetailHistorical->appraisal_header;
                $jumlah = $oAppraisalHeaderHistorical->appraisal_detail_historical()->sum("point");
                $oAppraisalHeaderHistorical->total_point =  $jumlah;
                $oAppraisalHeaderHistorical->save();

                return $this->sendResponse($oAppraisalDetailHistorical, $this->successStatus);
            }else{
                return $this->sendError(404, ['error'=> 'Appraisal Detail Historical does not exist.']);
            }
        } catch (\Exception $e) {
            return $this->sendError(500, ['error'=> $e]);
        
        }
    }
}
