<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Tenant\MasterTrainingType;
use App\Http\Requests\MasterTrainingType\StoreRequest;
use App\Http\Requests\MasterTrainingType\UpdateRequest;

class MasterTrainingTypeController extends Controller
{
    public function index(){
        try{
            $lsMasterTrainingType = MasterTrainingType::with('user_input','user_edit')->get();            
            return $this->sendResponse($lsMasterTrainingType, $this->successStatus);
        }catch (\Exception $e){
            return $this->sendError(500, ['error'=> $e]);
        }
    }

    public function listFilterAndPagine(Request $request){
        $filter = $request->filter;
        $count = $request->count;
               
        try{
            if (strlen($filter)>0){
                
                $lsMasterTrainingType = MasterTrainingType::with('user_input','user_edit')
                    ->where('training_type_code', 'like', '%' . $filter . '%')
                    ->orWhere('training_type_name', 'like', '%' . $filter . '%')
                    ->paginate($count);
                            
            }else{
                $lsMasterTrainingType = MasterTrainingType::with('user_input','user_edit')->paginate($count);
            }

            return $this->sendResponse($lsMasterTrainingType, $this->successStatus);
        }catch (\Exception $e){
            return $this->sendError(500, ['error'=> $e]);
        }        
    }

    public function show($id){
        try{
            $oMastterTrainingTypeterTrainingType = MasterTrainingType::find($id);

            if ($oMastterTrainingTypeterTrainingType) {
                return $this->sendResponse($oMastterTrainingTypeterTrainingType, $this->successStatus);
            }else{
                return $this->sendError(404, ['error'=> 'Master Training Type does not exist.']);
            }
        }catch (\Exception $e){
            return $this->sendError(500, ['error'=> $e]);
        }
    }

    public function store(StoreRequest $request){
        try{
            $oMastterTrainingTypeterTrainingType = new MasterTrainingType();
            $oMastterTrainingTypeterTrainingType->training_type_code = $request->training_type_code;
            $oMastterTrainingTypeterTrainingType->training_type_name = $request->training_type_name;
            $oMastterTrainingTypeterTrainingType->user_input = $request->get('userLoginId');  
            $oMastterTrainingTypeterTrainingType->user_edit = $request->get('userLoginId');       
            $oMastterTrainingTypeterTrainingType->save();
            return $this->sendResponse($oMastterTrainingTypeterTrainingType, $this->successStatus);
        }catch (\Exception $e){
            return $this->sendError(500, ['error'=> $e]);
        }
    }

    public function update(UpdateRequest $request,$id){
        try{
            $oMastterTrainingTypeterTrainingType = MasterTrainingType::find($id);

            if ($oMastterTrainingTypeterTrainingType) {
                $oMastterTrainingTypeterTrainingType->training_type_code = $request->training_type_code;
                $oMastterTrainingTypeterTrainingType->training_type_name = $request->training_type_name;
                $oMastterTrainingTypeterTrainingType->user_edit = $request->get('userLoginId');                
                $oMastterTrainingTypeterTrainingType->save();
                return $this->sendResponse($oMastterTrainingTypeterTrainingType, $this->successStatus);
            }else{
                return $this->sendError(404, ['error'=> 'Master Training Type does not exist.']);
            }
        }catch (\Exception $e){
            return $this->sendError(500, ['error'=> $e]);
        }
    }

    public function destroy($id){
        try{
            $oMastterTrainingType = MasterTrainingType::find($id);

            if ($oMastterTrainingType) {               
                $oMastterTrainingType->delete();
                return $this->sendResponse($oMastterTrainingType, $this->successStatus);
            }else{
                return $this->sendError(404, ['error'=> 'Master Training Type does not exist.']);
            }
        }catch (\Exception $e){
            return $this->sendError(500, ['error'=> $e]);
        }
    }
}
