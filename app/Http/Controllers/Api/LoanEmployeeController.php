<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Tenant\LoanEmployee;
use App\Http\Requests\LoanEmployee\StoreRequest;
use App\Http\Requests\LoanEmployee\UpdateRequest;

class LoanEmployeeController extends Controller
{
    public function index(){
        try{
            $lsLoanEmployee = LoanEmployee::with('pegawai','approved','submited','user_i','user_e')->get();
            
            return $this->sendResponse($lsLoanEmployee, $this->successStatus);
        }catch (\Exception $e){
            return $this->sendError(500, ['error'=> $e]);
        }
    }

    public function listFilterAndPagine(Request $request){
        $filter = $request->filter;
        $count = $request->count;
        try{
            if (strlen($filter)>0){
                $lsLoanEmployee =LoanEmployee::with('pegawai','approved','submited','user_i','user_e')
                    
                    ->whereHas('pegawai', function ($query) use($filter) {
                        $query->where('first_name', 'like', '%' . $filter . '%')
                        ->orWhere('middle_name', 'like', '%' . $filter . '%')
                        ->orWhere('last_name', 'like', '%' . $filter . '%');
                    })
                    ->orWhereHas('approved', function ($query) use($filter) {
                        $query->where('first_name', 'like', '%' . $filter . '%')
                        ->orWhere('middle_name', 'like', '%' . $filter . '%')
                        ->orWhere('last_name', 'like', '%' . $filter . '%');
                    })
                    ->orWhereHas('submited', function ($query) use($filter) {
                        $query->where('first_name', 'like', '%' . $filter . '%')
                        ->orWhere('middle_name', 'like', '%' . $filter . '%')
                        ->orWhere('last_name', 'like', '%' . $filter . '%');
                    })
                    ->orWhere('loan_number', 'like', '%' . $filter . '%')
                    ->orWhere('loan_date', 'like', '%' . $filter . '%')
                    ->orWhere('loan_amount', 'like', '%' . $filter . '%')
                    ->orWhere('loan_interest', 'like', '%' . $filter . '%')
                    ->orWhere('installments', 'like', '%' . $filter . '%')
                    ->orWhere('total_paid', 'like', '%' . $filter . '%')
                    ->orWhere('loan_source', 'like', '%' . $filter . '%')
                    ->orWhere('period', 'like', '%' . $filter . '%')
                    ->orWhere('total_loan', 'like', '%' . $filter . '%')
                    ->orWhere('loan_status', 'like', '%' . $filter . '%')
                    ->orWhere('process_date', 'like', '%' . $filter . '%')
                    ->orWhere('process_flag', 'like', '%' . $filter . '%')
                    ->orWhere('description', 'like', '%' . $filter . '%')
                    ->orWhere('collateral', 'like', '%' . $filter . '%')
                    ->orWhere('interest_type', 'like', '%' . $filter . '%')
                    ->orWhere('interest_of_installments', 'like', '%' . $filter . '%')
                    ->orWhere('remaining_loan', 'like', '%' . $filter . '%')
                    ->paginate($count);
            }else{
                $lsLoanEmployee =LoanEmployee::with('pegawai','approved','submited','user_i','user_e')->paginate($count);
            }
            
            
            return $this->sendResponse($lsLoanEmployee, $this->successStatus);
        }catch (\Exception $e){
            return $this->sendError(500, ['error'=> $e]);
        }
    }

    public function show($id){
        try{
            $lsLoanEmployee = LoanEmployee::with('pegawai','approved','submited','user_i','user_e')->find($id);

            if ($lsLoanEmployee) {
                return $this->sendResponse($lsLoanEmployee, $this->successStatus);
            }else{
                return $this->sendError(404, ['error'=> 'Loan Employee does not exist.']);
            }
        }catch (\Exception $e){
            return $this->sendError(500, ['error'=> $e]);
        }
    }

    public function store(StoreRequest $request){
        try{
            $oLoanEmployee = new LoanEmployee();
            $oLoanEmployee->employee_id = $request->employee_id;
            $oLoanEmployee->loan_number = "L.".$request->user()->company_name.".".date('YmdHis');
            $oLoanEmployee->loan_date = $request->loan_date;
            $oLoanEmployee->loan_amount = $request->loan_amount;
            $oLoanEmployee->loan_interest = $request->loan_interest;
            $oLoanEmployee->installments = $request->installments;
            $oLoanEmployee->total_paid = $request->total_paid;
            $oLoanEmployee->loan_source = $request->loan_source;
            $oLoanEmployee->period = $request->period;
            $oLoanEmployee->total_loan = $request->total_loan;
            $oLoanEmployee->loan_status = $request->loan_status;
            $oLoanEmployee->process_date = $request->process_date;
            $oLoanEmployee->process_flag = $request->process_flag;
            $oLoanEmployee->description = $request->description;
            $oLoanEmployee->approved_by = $request->approved_by;
            $oLoanEmployee->submitted_by = $request->submitted_by;
            $oLoanEmployee->collateral = $request->collateral;
            $oLoanEmployee->interest_type = $request->interest_type;
            $oLoanEmployee->interest_of_installments = $request->interest_of_installments;
            $oLoanEmployee->remaining_loan = $request->remaining_loan;
            $oLoanEmployee->user_input = $request->get('userLoginId');
            $oLoanEmployee->user_edit = $request->get('userLoginId');
            $oLoanEmployee->save();
            return $this->sendResponse($oLoanEmployee, $this->successStatus);
        }catch (\Exception $e){
            return $this->sendError(500, ['error'=> $e]);
        }
    }

    public function update(UpdateRequest $request,$id){
        try{
            $oLoanEmployee = LoanEmployee::find($id);

            if ($oLoanEmployee) {
                $oLoanEmployee->employee_id = $request->employee_id;
                $oLoanEmployee->loan_date = $request->loan_date;
                $oLoanEmployee->loan_amount = $request->loan_amount;
                $oLoanEmployee->loan_interest = $request->loan_interest;
                $oLoanEmployee->installments = $request->installments;
                $oLoanEmployee->total_paid = $request->total_paid;
                $oLoanEmployee->loan_source = $request->loan_source;
                $oLoanEmployee->period = $request->period;
                $oLoanEmployee->total_loan = $request->total_loan;
                $oLoanEmployee->loan_status = $request->loan_status;
                $oLoanEmployee->process_date = $request->process_date;
                $oLoanEmployee->process_flag = $request->process_flag;
                $oLoanEmployee->description = $request->description;
                $oLoanEmployee->approved_by = $request->approved_by;
                $oLoanEmployee->submitted_by = $request->submitted_by;
                $oLoanEmployee->collateral = $request->collateral;
                $oLoanEmployee->interest_type = $request->interest_type;
                $oLoanEmployee->interest_of_installments = $request->interest_of_installments;
                $oLoanEmployee->remaining_loan = $request->remaining_loan;
                $oLoanEmployee->user_edit = $request->get('userLoginId');
                $oLoanEmployee->save();
                return $this->sendResponse($oLoanEmployee, $this->successStatus);
            }else{
                return $this->sendError(404, ['error'=> 'Loan Employee does not exist.']);
            }
        }catch (\Exception $e){
            return $this->sendError(500, ['error'=> $e]);
        }
    }

    public function destroy($id){
        try{
            $oLoanEmployee = LoanEmployee::find($id);

            if ($oLoanEmployee) {               
                $oLoanEmployee->delete();
                return $this->sendResponse($oLoanEmployee, $this->successStatus);
            }else{
                return $this->sendError(404, ['error'=> 'Loan Employee does not exist.']);
            }
        }catch (\Exception $e){
            return $this->sendError(500, ['error'=> $e]);
        }
    }


}
