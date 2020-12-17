<?php

namespace App\Http\Controllers\Api;

use App\Model\Tenant\Family;
use App\Model\Main\Company;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Family\StoreRequest;
use App\Http\Requests\Family\UpdateRequest;
use Illuminate\Database\QueryException;
use File;
use Ramsey\Uuid\Uuid;

class FamilyController extends Controller
{
    public function index(){
        try{
            $lsFamily = Family::all();            
            return $this->sendResponse($lsFamily, $this->successStatus);
        }catch (\Exception $e){
            return $this->sendError(500, ['error'=> $e]);
        }
    }

    public function listFilterAndPagine(Request $request){
        $filter = $request->filter;
        $count = $request->count;
        $employeeId = $request->employee_id;
        if ($employeeId){
            try{
                if (strlen($filter)>0){
                    
                    $lsFamily = Family::where('employee_id', '=', ''.$employeeId.'')
                        ->where(function ($query) use($filter) {
                            $query->where('grade', 'like', '%' . $filter . '%')
                            ->orWhere('family_name', 'like', '%' . $filter . '%')
                            ->orWhere('birth_place', 'like', '%' . $filter . '%')
                            ->orWhere('birth_date', 'like', '%' . $filter . '%')
                            ->orWhere('gender', 'like', '%' . $filter . '%')
                            ->orWhere('relation', 'like', '%' . $filter . '%')
                            ->orWhere('phone_number', 'like', '%' . $filter . '%')
                            ->orWhere('job', 'like', '%' . $filter . '%')
                            ->orWhere('family_number_KK', 'like', '%' . $filter . '%')
                            ->orWhere('bpjs_kesehatan_number', 'like', '%' . $filter . '%')
                            ->orWhere('child_number', 'like', '%' . $filter . '%');
                        })->paginate($count);
                                
                }else{
                    $lsFamily = Family::where('employee_id', '=', ''.$employeeId.'')->paginate($count);
                }
    
                return $this->sendResponse($lsFamily, $this->successStatus);
            }catch (\Exception $e){
                return $this->sendError(500, ['error'=> $e]);
            }
        }else{
            return $this->sendError(404, ['error'=> 'employee_id is required']);
        }
        
    }

    public function show($id){
        try{
            $oFamily = Family::find($id);

            if ($oFamily) {
                return $this->sendResponse($oFamily, $this->successStatus);
            }else{
                return $this->sendError(404, ['error'=> 'Family does not exist.']);
            }
        }catch (\Exception $e){
            return $this->sendError(500, ['error'=> $e]);
        }
    }

    public function photoId(Request $request,$id){
        //list($companyName) = explode('.', $request->getHost(), 2);
        $companyName =$request->user()->company_name;
        $company = Company::where("company_name",$companyName)->first();
        $path = public_path()."/".$company->company_name."/".$id."";
        return response()->download($path);
    } 

    public function photoByObject(Request $request,$id){
        $companyName =$request->user()->company_name;
        //list($companyName) = explode('.', $request->getHost(), 2);
        $company = Company::where("company_name",$companyName)->first();

        try{
            $oFamily = Family::find($id);
            
            if ($oFamily) {
                $path = public_path()."/".$company->company_name."/".$oFamily->image_file_path."";
                return response()->download($path);
            }else{
                return $this->sendError(404, ['error'=> 'Family does not exist.']);
            }
        }catch(\Exception $e){
            return $this->sendError(500, ['error'=> $e]);
        }
        
    }

    public function store(StoreRequest $request){
        try {
            //find the company name, so it can store image on the right directory
            //list($companyName) = explode('.', $request->getHost(), 2);
            $companyName =$request->user()->company_name;
            $company = Company::where("company_name",$companyName)->first();

            //files            
            $path = "";
            $fileName ="";
            
            if ($request->hasFile('image_file_path')) {
                //if image valid then store here
                //check folder for the company already created or not
                if (! File::exists(public_path()."/".$company->company_name."")) {
                    // if not then make new folder            
                    File::makeDirectory(public_path()."/".$company->company_name."",$mode = 0777, true, true);
                }
                //upload the file
                $fileName = Uuid::uuid4()->getHex().".jpg";
                $path = $request->file('image_file_path')->move(public_path('/'.$company->company_name.'/'),$fileName);               
            }

            //save family 
            $oFamily = new Family();
            $oFamily ->employee_id = $request->employee_id;
            $oFamily ->family_name = $request->family_name;
            $oFamily ->birth_place = $request->birth_place;
            $oFamily ->birth_date = $request->birth_date;
            $oFamily ->gender = $request->gender;
            if (strlen($fileName)>0){
                $oFamily->image_file_path= $fileName;
            }else{
                $oFamily->image_file_path= "";
            }
            $oFamily->relation = $request->relation;
            $oFamily->phone_number = $request->phone_number;
            $oFamily->job = $request->job;
            $oFamily->family_number_KK = $request->family_number_KK;
            $oFamily->bpjs_kesehatan_number = $request->bpjs_kesehatan_number;
            $oFamily->child_number = $request->child_number;
            $oFamily->save();

            return $this->sendResponse($oFamily, $this->successStatus);

        }catch (\Exception $e){
            return $this->sendError(500, ['error'=> $e]);
        }
    }

    public function update(UpdateRequest $request, $id){
        try{
            $oFamily = Family::find($id);

            if ($oFamily) {
                //find the company name, so it can store image on the right directory
                $companyName =$request->user()->company_name;
                //list($companyName) = explode('.', $request->getHost(), 2);
                $company = Company::where("company_name",$companyName)->first();

                
                
                //files            
                $path = "";
                $fileName ="";
                
                if ($request->hasFile('image_file_path')) {
                    //delete old photo
                    if (strlen($oFamily->image_file_path)>0){
                        //check if this pegawai has a photo
                        if(file_exists(public_path().'/'.$company->company_name.'/'.$oFamily->image_file_path)){
                            //if the file exist the delete
                            File::delete(public_path().'/'.$company->company_name.'/'.$oFamily->image_file_path);
                        }
                    }
                    //upload new photo
                    if (! File::exists(public_path()."/".$company->company_name."")) {
                        // if not then make new folder            
                        File::makeDirectory(public_path()."/".$company->company_name."",$mode = 0777, true, true);
                    }
                    //upload the file
                    $fileName = Uuid::uuid4()->getHex().".jpg";
                    $path = $request->file('image_file_path')->move(public_path('/'.$company->company_name.'/'),$fileName); 
                   
                }

                
                $oFamily ->employee_id = $request->employee_id;
                $oFamily ->family_name = $request->family_name;
                $oFamily ->birth_place = $request->birth_place;
                $oFamily ->birth_date = $request->birth_date;
                $oFamily ->gender = $request->gender;
                if (strlen($fileName)>0){
                    $oFamily->image_file_path= $fileName;
                }
                $oFamily->relation = $request->relation;
                $oFamily->phone_number = $request->phone_number;
                $oFamily->job = $request->job;
                $oFamily->family_number_KK = $request->family_number_KK;
                $oFamily->bpjs_kesehatan_number = $request->bpjs_kesehatan_number;
                $oFamily->child_number = $request->child_number;
                $oFamily->save();

                return $this->sendResponse($oFamily, $this->successStatus);
            }else{
                return $this->sendError(404, ['error'=> 'Family does not exist.']);
            }
        }catch (\Exception $e){
            return $this->sendError(500, ['error'=> $e]);
        }
    }

    public function destroy($id){
        try{
            $oFamily = Family::find($id);

            if ($oFamily) {               
                $oFamily->delete();
                return $this->sendResponse($oFamily, $this->successStatus);
            }else{
                return $this->sendError(404, ['error'=> 'Family does not exist.']);
            }
        }catch (\Exception $e){
            return $this->sendError(500, ['error'=> $e]);
        }
    }
}
