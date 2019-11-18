<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Tenant\LoanInstallmentsHistory;
use App\Http\Requests\LoanInstallmentsHistory\StoreRequest;
use App\Http\Requests\LoanInstallmentsHistory\UpdateRequest;

class LoanInstallmentsHistoryController extends Controller
{
    public function index(){
        try{
            $lsLoanInstallmentsHistory = LoanInstallmentsHistory::with('pegawai','user_i','user_e')->get();
            
            return $this->sendResponse($lsLoanInstallmentsHistory, $this->successStatus);
        }catch (\Exception $e){
            return $this->sendError(500, ['error'=> $e]);
        }
    }

    public function listFilterAndPagine(Request $request){
        $filter = $request->filter;
        $count = $request->count;
        $loanNumber = $request->loan_number;
        if ($loanNumber){
            try{
                //dd($filter);
                if (strlen($filter)>0){
                    
                    $lsLoanInstallmentsHistory =LoanInstallmentsHistory::with('pegawai','user_i','user_e')
                        ->where('loan_number','=',''.$loanNumber.'')
                        
                        ->where(function ($query) use($filter) {
                            $query->where('intallments_date', 'like', '%' . $filter . '%')
                            ->orWhere('installments_amount', 'like', '%' . $filter . '%')
                            ->orWhere('description', 'like', '%' . $filter . '%')
                            ->orWhereHas('pegawai', function ($query) use($filter) {
                                $query->where('first_name', 'like', '%' . $filter . '%')
                                ->orWhere('middle_name', 'like', '%' . $filter . '%')
                                ->orWhere('last_name', 'like', '%' . $filter . '%');
                            });
                        })
                        
                        ->paginate($count);
                }else{
                    $lsLoanInstallmentsHistory =LoanInstallmentsHistory::with('pegawai','user_i','user_e')->paginate($count);
                }
                
                
                return $this->sendResponse($lsLoanInstallmentsHistory, $this->successStatus);
            }catch (\Exception $e){
                return $this->sendError(500, ['error'=> $e]);
            }
        }else{
            return $this->sendError(404, ['error'=> 'loan_number is required']);
        }
        
    }

    public function show($id){
        try{
            $lsLoanInstallmentsHistory = LoanInstallmentsHistory::with('pegawai','user_i','user_e')->find($id);

            if ($lsLoanInstallmentsHistory) {
                return $this->sendResponse($lsLoanInstallmentsHistory, $this->successStatus);
            }else{
                return $this->sendError(404, ['error'=> 'Loan Installments History does not exist.']);
            }
        }catch (\Exception $e){
            return $this->sendError(500, ['error'=> $e]);
        }
    }

    public function store(StoreRequest $request){
        try{
            $lsLoanInstallmentsHistory = new LoanInstallmentsHistory();
            $lsLoanInstallmentsHistory->employee_id = $request->employee_id;
            $lsLoanInstallmentsHistory->loan_number = $request->loan_number;
            $lsLoanInstallmentsHistory->intallments_date = $request->intallments_date;
            $lsLoanInstallmentsHistory->installments_amount = $request->installments_amount;
            $lsLoanInstallmentsHistory->description = $request->description;
            $lsLoanInstallmentsHistory->user_input = $request->get('userLoginId');
            $lsLoanInstallmentsHistory->user_edit = $request->get('userLoginId');
            $lsLoanInstallmentsHistory->save();
            return $this->sendResponse($lsLoanInstallmentsHistory, $this->successStatus);
        }catch (\Exception $e){
            return $this->sendError(500, ['error'=> $e]);
        }
    }

    public function update(UpdateRequest $request,$id){
        try{
            $oLoanInstallmentsHistory = LoanInstallmentsHistory::find($id);

            if ($oLoanInstallmentsHistory) {
                $oLoanInstallmentsHistory->employee_id = $request->employee_id;
                $oLoanInstallmentsHistory->loan_number = $request->loan_number;
                $oLoanInstallmentsHistory->intallments_date = $request->intallments_date;
                $oLoanInstallmentsHistory->installments_amount = $request->installments_amount;
                $oLoanInstallmentsHistory->description = $request->description;
                $oLoanInstallmentsHistory->user_edit = $request->get('userLoginId');
                $oLoanInstallmentsHistory->save();
                return $this->sendResponse($oLoanInstallmentsHistory, $this->successStatus);
            }else{
                return $this->sendError(404, ['error'=> 'Loan Installments History does not exist.']);
            }
        }catch (\Exception $e){
            return $this->sendError(500, ['error'=> $e]);
        }
    }

    public function destroy($id){
        try{
            
            $oLoanInstallmentsHistory = LoanInstallmentsHistory::find($id);

            if ($oLoanInstallmentsHistory) {               
                $oLoanInstallmentsHistory->delete();
                return $this->sendResponse($oLoanInstallmentsHistory, $this->successStatus);
            }else{
                return $this->sendError(404, ['error'=> 'Loan Installments History does not exist.']);
            }
        }catch (\Exception $e){
            return $this->sendError(500, ['error'=> $e]);
        }
    }
}
