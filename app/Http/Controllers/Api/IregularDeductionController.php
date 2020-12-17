<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Tenant\IregularDeduction;
use App\Http\Requests\IregularDeduction\StoreRequest;
use App\Http\Requests\IregularDeduction\UpdateRequest;

class IregularDeductionController extends Controller
{
    public function index(){
        try{
            $lsIregularDeduction = IregularDeduction::with('pegawai','salary_master_data','user_i','user_e')->get();            
            return $this->sendResponse($lsIregularDeduction, $this->successStatus);
        }catch (\Exception $e){
            return $this->sendError(500, ['error'=> $e]);
        }
    
    }

    public function show($id){
        try{
            $oIregularDeduction = IregularDeduction::with('pegawai','salary_master_data','user_i','user_e')->find($id);

            if ($oIregularDeduction) {
                return $this->sendResponse($oIregularDeduction, $this->successStatus);
            }else{
                return $this->sendError(404, ['error'=> 'Iregular Deduction does not exist.']);
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
                $lsIregularDeduction = IregularDeduction::with('pegawai','salary_master_data','user_i','user_e')
                    ->whereHas('pegawai', function ($query) use($filter) {
                        $query->where('first_name', 'like', '%' . $filter . '%')
                        ->orWhere('middle_name', 'like', '%' . $filter . '%')
                        ->orWhere('last_name', 'like', '%' . $filter . '%');
                    })
                    ->orWhereHas('salary_master_data', function ($query) use($filter) {
                        $query->where('salary_name', 'like', '%' . $filter . '%');
                    })
                    ->orWhere('employee_id', 'like', '%' . $filter . '%')
                    ->orWhere('deduction_date', 'like', '%' . $filter . '%')
                    ->orWhere('amount', 'like', '%' . $filter . '%')
                    ->orWhere('salary_code', 'like', '%' . $filter . '%')
                    ->orWhere('description', 'like', '%' . $filter . '%')
                    ->paginate($count);
            }else{
                $lsIregularDeduction = IregularDeduction::with('pegawai','salary_master_data','user_i','user_e')->paginate($count);
            }
            
            
            return $this->sendResponse($lsIregularDeduction, $this->successStatus);
        }catch (\Exception $e){
            return $this->sendError(500, ['error'=> $e]);
        }
    }

    public function store(StoreRequest $request){
        try{
            $oIregularDeduction = new IregularDeduction();
            $oIregularDeduction->employee_id = $request->employee_id;
            $oIregularDeduction->deduction_date = $request->deduction_date;
            $oIregularDeduction->amount = $request->amount;
            $oIregularDeduction->salary_code = $request->salary_code;
            $oIregularDeduction->description = $request->description;
            $oIregularDeduction->user_input = $request->get('userLoginId');
            $oIregularDeduction->user_edit = $request->get('userLoginId');
            $oIregularDeduction->save();
            return $this->sendResponse($oIregularDeduction, $this->successStatus);
        }catch (\Exception $e){
            return $this->sendError(500, ['error'=> $e]);
        }
    }

    public function update(UpdateRequest $request,$id){
        try{
            $oIregularDeduction = IregularDeduction::find($id);

            if ($oIregularDeduction) {
                $oIregularDeduction->employee_id = $request->employee_id;
                $oIregularDeduction->deduction_date = $request->deduction_date;
                $oIregularDeduction->amount = $request->amount;
                $oIregularDeduction->salary_code = $request->salary_code;
                $oIregularDeduction->description = $request->description;
                $oIregularDeduction->user_edit = $request->get('userLoginId');
                $oIregularDeduction->save();
                return $this->sendResponse($oIregularDeduction, $this->successStatus);
            }else{
                return $this->sendError(404, ['error'=> 'Iregular Deduction does not exist.']);
            }
        }catch (\Exception $e){
            return $this->sendError(500, ['error'=> $e]);
        }
    }

    public function destroy($id){
        try{
            $oIregularDeduction = IregularDeduction::find($id);

            if ($oIregularDeduction) {               
                $oIregularDeduction->delete();
                return $this->sendResponse($oIregularDeduction, $this->successStatus);
            }else{
                return $this->sendError(404, ['error'=> 'Iregular Deduction does not exist.']);
            }
        }catch (\Exception $e){
            return $this->sendError(500, ['error'=> $e]);
        }
    }
}
