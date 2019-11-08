<?php

namespace App\Http\Controllers\Api;

use App\Model\Tenant\BpjsRate;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Ramsey\Uuid\Uuid;
use App\Http\Requests\BpjsRate\StoreRequest;
use App\Http\Requests\BpjsRate\UpdateRequest;



class BpjsRateController extends Controller
{
    public function index(){
        try{
            $bpjsRate = BpjsRate::all();
            
            return $this->sendResponse($bpjsRate, $this->successStatus);
        }catch (\Exception $e){
            return $this->sendError(500, ['error'=> $e]);
        }
    }

    public function listFilterAndPagine(Request $request){
        $filter = $request->filter;
        $count = $request->count;
        try{
            if (strlen($filter)>0){
                $bpjsRate = BpjsRate::where('description', 'like', '%' . $filter . '%')
                            ->orWhere('jhtp', 'like', '%' . $filter . '%')
                            ->orWhere('jhtk', 'like', '%' . $filter . '%')
                            ->orWhere('jk', 'like', '%' . $filter . '%')
                            ->orWhere('jkk', 'like', '%' . $filter . '%')
                            ->orWhere('jpk_lajang', 'like', '%' . $filter . '%')
                            ->orWhere('jpk_nikah', 'like', '%' . $filter . '%')
                            ->orWhere('bpjsp', 'like', '%' . $filter . '%')
                            ->orWhere('bpjsk', 'like', '%' . $filter . '%')
                            ->orWhere('max_salary_pension', 'like', '%' . $filter . '%')
                            ->orWhere('max_salary_medical', 'like', '%' . $filter . '%')
                            ->orWhere('pension_company', 'like', '%' . $filter . '%')
                            ->orWhere('pension_employees', 'like', '%' . $filter . '%')
                            ->paginate($count);
            }else{
                $bpjsRate = BpjsRate::paginate($count);
            }
            
            
            return $this->sendResponse($bpjsRate, $this->successStatus);
        }catch (\Exception $e){
            return $this->sendError(500, ['error'=> $e]);
        }
    }

    public function show($id){
        try{
            $oBpjsRate = BpjsRate::find($id);

            if ($oBpjsRate) {
                return $this->sendResponse($oBpjsRate, $this->successStatus);
            }else{
                return $this->sendError(404, ['error'=> 'BPJS Rate does not exist.']);
            }
        }catch (\Exception $e){
            return $this->sendError(500, ['error'=> $e]);
        }
    }

    public function store(StoreRequest $request){
        try{
            $oBpjsRate = new BpjsRate();
            $oBpjsRate->code = Uuid::uuid4()->getHex();
            $oBpjsRate->description = $request->description;
            $oBpjsRate->jhtp = $request->jhtp;
            $oBpjsRate->jhtk = $request->jhtk;
            $oBpjsRate->jk = $request->jk;
            $oBpjsRate->jkk = $request->jkk;
            $oBpjsRate->jpk_lajang = $request->jpk_lajang;
            $oBpjsRate->jpk_nikah = $request->jpk_nikah;
            $oBpjsRate->bpjsp = $request->bpjsp;
            $oBpjsRate->bpjsk = $request->bpjsk;
            $oBpjsRate->max_salary_pension = $request->max_salary_pension;
            $oBpjsRate->max_salary_medical = $request->max_salary_medical;
            $oBpjsRate->pension_company = $request->pension_company;
            $oBpjsRate->pension_employees = $request->pension_employees;
            $oBpjsRate->save();
            return $this->sendResponse($oBpjsRate, $this->successStatus);
        }catch (\Exception $e){
            return $this->sendError(500, ['error'=> $e]);
        }
    }

    public function update(UpdateRequest $request, $id){
        try{
            $oBpjsRate = BpjsRate::find($id);

            if ($oBpjsRate) {
                $oBpjsRate->description = $request->description;
                $oBpjsRate->jhtp = $request->jhtp;
                $oBpjsRate->jhtk = $request->jhtk;
                $oBpjsRate->jk = $request->jk;
                $oBpjsRate->jkk = $request->jkk;
                $oBpjsRate->jpk_lajang = $request->jpk_lajang;
                $oBpjsRate->jpk_nikah = $request->jpk_nikah;
                $oBpjsRate->bpjsp = $request->bpjsp;
                $oBpjsRate->bpjsk = $request->bpjsk;
                $oBpjsRate->max_salary_pension = $request->max_salary_pension;
                $oBpjsRate->max_salary_medical = $request->max_salary_medical;
                $oBpjsRate->pension_company = $request->pension_company;
                $oBpjsRate->pension_employees = $request->pension_employees;
                $oBpjsRate->save();
                return $this->sendResponse($oBpjsRate, $this->successStatus);
            }else{
                return $this->sendError(404, ['error'=> 'BPJS Rate does not exist.']);
            }
        }catch (\Exception $e){
            return $this->sendError(500, ['error'=> $e]);
        }
    }

    public function destroy($id){
        try{
            $oBpjsRate = BpjsRate::find($id);

            if ($oBpjsRate) {               
                $oBpjsRate->delete();
                return $this->sendResponse($oBpjsRate, $this->successStatus);
            }else{
                return $this->sendError(404, ['error'=> 'BPJS Rate does not exist.']);
            }
        }catch (\Exception $e){
            return $this->sendError(500, ['error'=> $e]);
        }
    }
}
