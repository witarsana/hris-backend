<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Tenant\IregularIncome;
use App\Http\Requests\IregularIncome\StoreRequest;
use App\Http\Requests\IregularIncome\UpdateRequest;

class IregularIncomeController extends Controller
{
    public function index(){
        try{
            $lsIregularIncome = IregularIncome::with('pegawai','salary_master_data','user_i','user_e')->get();            
            return $this->sendResponse($lsIregularIncome, $this->successStatus);
        }catch (\Exception $e){
            return $this->sendError(500, ['error'=> $e]);
        }
    
    }

    public function show($id){
        try{
            $oIregularIncome = IregularIncome::with('pegawai','salary_master_data','user_i','user_e')->find($id);

            if ($oIregularIncome) {
                return $this->sendResponse($oIregularIncome, $this->successStatus);
            }else{
                return $this->sendError(404, ['error'=> 'Iregular Income does not exist.']);
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
                $lsIregularIncome = IregularIncome::with('pegawai','salary_master_data','user_i','user_e')
                    ->whereHas('pegawai', function ($query) use($filter) {
                        $query->where('first_name', 'like', '%' . $filter . '%')
                        ->orWhere('middle_name', 'like', '%' . $filter . '%')
                        ->orWhere('last_name', 'like', '%' . $filter . '%');
                    })
                    ->orWhereHas('salary_master_data', function ($query) use($filter) {
                        $query->where('salary_name', 'like', '%' . $filter . '%');
                    })
                    ->orWhere('employee_id', 'like', '%' . $filter . '%')
                    ->orWhere('income_date', 'like', '%' . $filter . '%')
                    ->orWhere('amount', 'like', '%' . $filter . '%')
                    ->orWhere('salary_code', 'like', '%' . $filter . '%')
                    ->orWhere('description', 'like', '%' . $filter . '%')
                    ->paginate($count);
            }else{
                $lsIregularIncome = IregularIncome::with('pegawai','salary_master_data','user_i','user_e')->paginate($count);
            }
            
            
            return $this->sendResponse($lsIregularIncome, $this->successStatus);
        }catch (\Exception $e){
            return $this->sendError(500, ['error'=> $e]);
        }
    }

    public function store(StoreRequest $request){
        try{
            $oIregularIncome = new IregularIncome();
            $oIregularIncome->employee_id = $request->employee_id;
            $oIregularIncome->income_date = $request->income_date;
            $oIregularIncome->amount = $request->amount;
            $oIregularIncome->salary_code = $request->salary_code;
            $oIregularIncome->description = $request->description;
            $oIregularIncome->user_input = $request->get('userLoginId');
            $oIregularIncome->user_edit = $request->get('userLoginId');
            $oIregularIncome->save();
            return $this->sendResponse($oIregularIncome, $this->successStatus);
        }catch (\Exception $e){
            return $this->sendError(500, ['error'=> $e]);
        }
    }

    public function update(UpdateRequest $request,$id){
        try{
            $oIregularIncome = IregularIncome::find($id);

            if ($oIregularIncome) {
                $oIregularIncome->employee_id = $request->employee_id;
                $oIregularIncome->income_date = $request->income_date;
                $oIregularIncome->amount = $request->amount;
                $oIregularIncome->salary_code = $request->salary_code;
                $oIregularIncome->description = $request->description;
                $oIregularIncome->user_edit = $request->get('userLoginId');
                $oIregularIncome->save();
                return $this->sendResponse($oIregularIncome, $this->successStatus);
            }else{
                return $this->sendError(404, ['error'=> 'Iregular Income does not exist.']);
            }
        }catch (\Exception $e){
            return $this->sendError(500, ['error'=> $e]);
        }
    }

    public function destroy($id){
        try{
            $oIregularIncome = IregularIncome::find($id);

            if ($oIregularIncome) {               
                $oIregularIncome->delete();
                return $this->sendResponse($oIregularIncome, $this->successStatus);
            }else{
                return $this->sendError(404, ['error'=> 'Iregular Income does not exist.']);
            }
        }catch (\Exception $e){
            return $this->sendError(500, ['error'=> $e]);
        }
    }
}
