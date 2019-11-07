<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Tenant\AppraisalHeaderHistorical;
use App\Http\Requests\AppraisalHeaderHistorical\StoreRequest;
use App\Http\Requests\AppraisalHeaderHistorical\UpdateRequest;
use Ramsey\Uuid\Uuid;

class AppraisalHeaderHistoricalController extends Controller
{
    public function index (){
        try {
            $lsAppraisalHeaderHistorical = AppraisalHeaderHistorical::with('pegawai','user_i','user_e','appraisal_detail_historical','appraisal_detail_historical.appraisal_master','appraisal_detail_historical.user_i','appraisal_detail_historical.user_e')->get();            
            return $this->sendResponse($lsAppraisalHeaderHistorical, $this->successStatus);
        } catch (\Exception $e) {
            return $this->sendError(500, ['error'=> $e]);
        }
    }

    public function listFilterAndPagine(Request $request){
        $filter = $request->filter;
        $count = $request->count;
              
        try{
            if (strlen($filter)>0){
                
                $lsAppraisalHeaderHistorical = AppraisalHeaderHistorical::with('pegawai','user_i','user_e','appraisal_detail_historical.appraisal_master','appraisal_detail_historical.user_i','appraisal_detail_historical.user_e')
                    ->whereHas('pegawai', function ($query) use($filter) {
                        $query->where('first_name', 'like', '%' . $filter . '%')
                        ->orWhere('middle_name', 'like', '%' . $filter . '%')
                        ->orWhere('last_name', 'like', '%' . $filter . '%')
                        ->orWhere('total_point', 'like', '%' . $filter . '%')
                        ->orWhere('appraisal_month', 'like', '%' . $filter . '%')
                        ->orWhere('appraisal_year', 'like', '%' . $filter . '%')
                        ->orWhere('description', 'like', '%' . $filter . '%'); 
                    })->paginate($count);
                            
            }else{
                $lsAppraisalHeaderHistorical = AppraisalHeaderHistorical::with('pegawai','appraisal_detail_historical.appraisal_master','user_i','user_e')->paginate($count);
            }

            return $this->sendResponse($lsAppraisalHeaderHistorical, $this->successStatus);
        }catch (\Exception $e){
            return $this->sendError(500, ['error'=> $e]);
        }
             
    }

    public function show($id){
        try{
            $oAppraisalHeaderHistorical = AppraisalHeaderHistorical::with('pegawai','appraisal_detail_historical.appraisal_master','user_i','user_e')->find($id);

            if ($oAppraisalHeaderHistorical) {
                return $this->sendResponse($oAppraisalHeaderHistorical, $this->successStatus);
            }else{
                return $this->sendError(404, ['error'=> 'Appraisal Header Historical does not exist.']);
            }
        }catch (\Exception $e){
            return $this->sendError(500, ['error'=> $e]);
        }
    }

    public function store(StoreRequest $request){
        try {
            $oAppraisalHeaderHistorical = new AppraisalHeaderHistorical();
            $oAppraisalHeaderHistorical->appraisal_code = Uuid::uuid4()->getHex();
            $oAppraisalHeaderHistorical->employee_id = $request->employee_id;
            $oAppraisalHeaderHistorical->total_point = $request->total_point;
            $oAppraisalHeaderHistorical->appraisal_month = $request->appraisal_month;
            $oAppraisalHeaderHistorical->appraisal_year = $request->appraisal_year;
            $oAppraisalHeaderHistorical->description = $request->description;
            $oAppraisalHeaderHistorical->user_input = $request->get('userLoginId'); 
            $oAppraisalHeaderHistorical->user_edit = $request->get('userLoginId'); 
            $oAppraisalHeaderHistorical->save();
            return $this->sendResponse($oAppraisalHeaderHistorical, $this->successStatus);
        } catch (\Exception $e) {
            return $this->sendError(500, ['error'=> $e]);
        }
    }

    public function update(UpdateRequest $request,$id){
        try{
            
            $oAppraisalHeaderHistorical = AppraisalHeaderHistorical::find($id);
            
            if ($oAppraisalHeaderHistorical) {
                $oAppraisalHeaderHistorical->employee_id = $request->employee_id;
                $oAppraisalHeaderHistorical->total_point = $request->total_point;
                $oAppraisalHeaderHistorical->appraisal_month = $request->appraisal_month;
                $oAppraisalHeaderHistorical->appraisal_year = $request->appraisal_year;
                $oAppraisalHeaderHistorical->description = $request->description;
                $oAppraisalHeaderHistorical->user_edit = $request->get('userLoginId'); 
                $oAppraisalHeaderHistorical->save();
                return $this->sendResponse($oAppraisalHeaderHistorical, $this->successStatus);
            }else{
                return $this->sendError(404, ['error'=> 'Appraisal Header Historical does not exist.']);
            }
        }catch (\Exception $e){
            return $this->sendError(500, ['error'=> $e]);
        }
    }

    public function destroy($id){
        try {
            $oAppraisalHeaderHistorical = AppraisalHeaderHistorical::find($id);
            if ($oAppraisalHeaderHistorical) {
                $oAppraisalHeaderHistorical->delete();
                return $this->sendResponse($oAppraisalHeaderHistorical, $this->successStatus);
            }else{
                return $this->sendError(404, ['error'=> 'Appraisal Header Historical does not exist.']);
            }
        } catch (\Exception $e) {
            return $this->sendError(500, ['error'=> $e]);
        
        }
    }
}
