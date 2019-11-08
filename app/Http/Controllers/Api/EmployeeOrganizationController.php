<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Tenant\EmployeeOrganization;
use App\Http\Requests\EmployeeOrganization\StoreRequest;
use App\Http\Requests\EmployeeOrganization\UpdateRequest;

class EmployeeOrganizationController extends Controller
{
    public function index(){
        try{
            $lsEmployeeOrganization = EmployeeOrganization::with('pegawai','organization','user_i','user_e')->get();            
            return $this->sendResponse($lsEmployeeOrganization, $this->successStatus);
        }catch (\Exception $e){
            return $this->sendError(500, ['error'=> $e]);
        }
    }

    public function listFilterAndPagine(Request $request){
        $filter = $request->filter;
        $count = $request->count;
        try{
            if (strlen($filter)>0){
                $lsEmployeeOrganization = EmployeeOrganization::with('pegawai','organization','user_i','user_e')
                    ->whereHas('pegawai', function ($query) use($filter) {
                        $query->where('first_name', 'like', '%' . $filter . '%')
                        ->orWhere('middle_name', 'like', '%' . $filter . '%')
                        ->orWhere('last_name', 'like', '%' . $filter . '%');
                    })
                    ->orWhereHas('organization',function($query) use($filter){
                        $query->where('org_name', 'like', '%' . $filter . '%');
                    })
                    ->orWhere('employee_id', 'like', '%' . $filter . '%')
                    ->paginate($count);
            }else{
                $lsEmployeeOrganization = EmployeeOrganization::with('pegawai','organization','user_i','user_e')->paginate($count);
            }
            
            
            return $this->sendResponse($lsEmployeeOrganization, $this->successStatus);
        }catch (\Exception $e){
            return $this->sendError(500, ['error'=> $e]);
        }
    } 

    public function show($id){
        try{
            $oEmployeeOrganization = EmployeeOrganization::with('pegawai','organization','user_i','user_e')->find($id);

            if ($oEmployeeOrganization) {
                return $this->sendResponse($oEmployeeOrganization, $this->successStatus);
            }else{
                return $this->sendError(404, ['error'=> 'Employee Organization does not exist.']);
            }
        }catch (\Exception $e){
            return $this->sendError(500, ['error'=> $e]);
        }
    }

    public function store(StoreRequest $request){
        try{
            $oEmployeeOrganization = new EmployeeOrganization();
            $oEmployeeOrganization->employee_id = $request->employee_id;
            $oEmployeeOrganization->org_code = $request->org_code;
            $oEmployeeOrganization->user_input = $request->get('userLoginId');
            $oEmployeeOrganization->user_edit = $request->get('userLoginId');
            $oEmployeeOrganization->save();
            return $this->sendResponse($oEmployeeOrganization, $this->successStatus);
        }catch (\Exception $e){
            return $this->sendError(500, ['error'=> $e]);
        }
    }

    public function update(UpdateRequest $request,$id){
        try{
            $oEmployeeOrganization = EmployeeOrganization::find($id);

            if ($oEmployeeOrganization) {
                $oEmployeeOrganization->employee_id = $request->employee_id;
                $oEmployeeOrganization->org_code = $request->org_code;
                $oEmployeeOrganization->user_edit = $request->get('userLoginId');
                $oEmployeeOrganization->save();
                return $this->sendResponse($oEmployeeOrganization, $this->successStatus);
            }else{
                return $this->sendError(404, ['error'=> 'Employee Organization does not exist.']);
            }
        }catch (\Exception $e){
            return $this->sendError(500, ['error'=> $e]);
        }
    }

    public function destroy($id){
        try{
            $oEmployeeOrganization = EmployeeOrganization::find($id);

            if ($oEmployeeOrganization) {
                $oEmployeeOrganization->delete();
                return $this->sendResponse($oEmployeeOrganization, $this->successStatus);
            }else{
                return $this->sendError(404, ['error'=> 'Employee Organization does not exist.']);
            }
        }catch (\Exception $e){
            return $this->sendError(500, ['error'=> $e]);
        }
    }
}
