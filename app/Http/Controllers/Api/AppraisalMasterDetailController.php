<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Ramsey\Uuid\Uuid;
use App\Model\Tenant\AppraisalMasterDetail;
use App\Http\Requests\AppraisalMasterDetail\StoreRequest;
use App\Http\Requests\AppraisalMasterDetail\UpdateRequest;

class AppraisalMasterDetailController extends Controller
{
    public function index(){
        try{
            $lsAppraisalMasterDetail = AppraisalMasterDetail::with('user_i','user_e')->get();
            
            return $this->sendResponse($lsAppraisalMasterDetail, $this->successStatus);
        }catch (\Exception $e){
            return $this->sendError(500, ['error'=> $e]);
        }
    }

    public function listFilterAndPagine(Request $request){
        $filter = $request->filter;
        $count = $request->count;
        try{
            if (strlen($filter)>0){
                $lsAppraisalMasterDetail = AppraisalMasterDetail::with('user_i','user_e')
                            ->where('appraisal_name', 'like', '%' . $filter . '%')                            
                            ->paginate($count);
            }else{
                $lsAppraisalMasterDetail = AppraisalMasterDetail::with('user_i','user_e')->paginate($count);
            }
            
            
            return $this->sendResponse($lsAppraisalMasterDetail, $this->successStatus);
        }catch (\Exception $e){
            return $this->sendError(500, ['error'=> $e]);
        }
    }

    public function show($id){
        try{
            $oAppraisalMasterDetail = AppraisalMasterDetail::with('user_i','user_e')->find($id);

            if ($oAppraisalMasterDetail) {
                return $this->sendResponse($oAppraisalMasterDetail, $this->successStatus);
            }else{
                return $this->sendError(404, ['error'=> 'Appraisal Master Detail does not exist.']);
            }
        }catch (\Exception $e){
            return $this->sendError(500, ['error'=> $e]);
        }
    }

    public function store(StoreRequest $request){
        try{
            $oAppraisalMasterDetail = new AppraisalMasterDetail();
            $oAppraisalMasterDetail->appraisal_detail_code = Uuid::uuid4()->getHex();
            $oAppraisalMasterDetail->appraisal_name = $request->appraisal_name;    
            $oAppraisalMasterDetail->user_input = $request->get('userLoginId'); 
            $oAppraisalMasterDetail->user_edit = $request->get('userLoginId');         
            $oAppraisalMasterDetail->save();
            return $this->sendResponse($oAppraisalMasterDetail, $this->successStatus);
        }catch (\Exception $e){
            return $this->sendError(500, ['error'=> $e]);
        }
    }

    public function update(UpdateRequest $request,$id){
        try{
            $oAppraisalMasterDetail = AppraisalMasterDetail::find($id);
            
            if ($oAppraisalMasterDetail) {
                $oAppraisalMasterDetail->appraisal_name = $request->appraisal_name;               
                $oAppraisalMasterDetail->user_edit = $request->get('userLoginId'); 
                $oAppraisalMasterDetail->save();
                return $this->sendResponse($oAppraisalMasterDetail, $this->successStatus);
            }else{
                return $this->sendError(404, ['error'=> 'Appraisal Master Detail does not exist.']);
            }
        }catch (\Exception $e){
            return $this->sendError(500, ['error'=> $e]);
        }
    }

    public function destroy($id){
        try{
            $oAppraisalMasterDetail = AppraisalMasterDetail::find($id);
            
            if ($oAppraisalMasterDetail) {               
                $oAppraisalMasterDetail->delete();
                return $this->sendResponse($oAppraisalMasterDetail, $this->successStatus);
            }else{
                return $this->sendError(404, ['error'=> 'Appraisal Master Detail does not exist.']);
            }
        }catch (\Exception $e){
            return $this->sendError(500, ['error'=> $e]);
        }
    }
}
