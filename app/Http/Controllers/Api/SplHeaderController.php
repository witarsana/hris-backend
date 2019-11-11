<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Tenant\SplHeader;
use App\Http\Requests\SplHeader\StoreRequest;
use App\Http\Requests\SplHeader\UpdateRequest;
use App\Http\Requests\SplHeader\ApprovalRequest;

class SplHeaderController extends Controller
{
    public function index(){
        try{
            $lsSplHeader = SplHeader::with('user_i','user_e')->get();            
            return $this->sendResponse($lsSplHeader, $this->successStatus);
        }catch (\Exception $e){
            return $this->sendError(500, ['error'=> $e]);
        }
    
    }

    public function show($id){
        try{
            $oSplHeader = SplHeader::with('user_i','user_e')->find($id);

            if ($oSplHeader) {
                return $this->sendResponse($oSplHeader, $this->successStatus);
            }else{
                return $this->sendError(404, ['error'=> 'Spl Header does not exist.']);
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
                $lsSplHeader = SplHeader::with('user_i','user_e')
                    ->where('spl_number', 'like', '%' . $filter . '%')
                    ->orWhere('overtime_date', 'like', '%' . $filter . '%')
                    ->orWhere('approval_status', 'like', '%' . $filter . '%')
                    ->paginate($count);
            }else{
                $lsSplHeader = SplHeader::with('user_i','user_e')->paginate($count);
            }
            return $this->sendResponse($lsSplHeader, $this->successStatus);
        }catch (\Exception $e){
            return $this->sendError(500, ['error'=> $e]);
        }
    }

    public function store(StoreRequest $request){
        try{
            $oSplHeader = new SplHeader();
            //make new SPL Number
            $newNumber = "SPL.".$request->user()->company_name.".".date('YmdHis');
            $oSplHeader->spl_number = $newNumber;
            $oSplHeader->overtime_date = $request->overtime_date;
            //$oSplHeader->approval_status = $request->approval_status;
            $oSplHeader->user_input = $request->get('userLoginId');
            $oSplHeader->user_edit = $request->get('userLoginId');
            $oSplHeader->save();
            return $this->sendResponse($oSplHeader, $this->successStatus);
        }catch (\Exception $e){
            return $this->sendError(500, ['error'=> $e]);
        }
    }

    public function update(UpdateRequest $request,$id){
        try{
            $oSplHeader = SplHeader::find($id);

            if ($oSplHeader) {
                $oSplHeader->overtime_date = $request->overtime_date;
                //$oSplHeader->approval_status = $request->approval_status;
                $oSplHeader->user_edit = $request->get('userLoginId');
                $oSplHeader->save();
                return $this->sendResponse($oSplHeader, $this->successStatus);
            }else{
                return $this->sendError(404, ['error'=> 'Spl Header does not exist.']);
            }
        }catch (\Exception $e){
            return $this->sendError(500, ['error'=> $e]);
        }
    }

    public function approval(ApprovalRequest $request,$id){
        try{
            $oSplHeader = SplHeader::find($id);

            if ($oSplHeader) {
                $oSplHeader->approval_status = $request->approval_status;
                $oSplHeader->user_edit = $request->get('userLoginId');
                $oSplHeader->save();
                return $this->sendResponse($oSplHeader, $this->successStatus);
            }else{
                return $this->sendError(404, ['error'=> 'Spl Header does not exist.']);
            }
        }catch (\Exception $e){
            return $this->sendError(500, ['error'=> $e]);
        }
    }

    public function destroy($id){
        try{
            $oSplHeader = SplHeader::find($id);

            if ($oSplHeader) {               
                $oSplHeader->delete();
                return $this->sendResponse($oSplHeader, $this->successStatus);
            }else{
                return $this->sendError(404, ['error'=> 'Spl Header does not exist.']);
            }
        }catch (\Exception $e){
            return $this->sendError(500, ['error'=> $e]);
        }
    }
}
