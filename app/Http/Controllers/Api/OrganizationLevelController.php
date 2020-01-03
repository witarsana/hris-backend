<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Model\Tenant\OrganizationLevel;
use Illuminate\Http\Request;
use App\Http\Requests\OrganizationLevel\StoreRequest;
use App\Http\Requests\OrganizationLevel\UpdateRequest;
use Ramsey\Uuid\Uuid;


class OrganizationLevelController extends Controller
{
    public function index(){
        try{
            $OrganizationLevel = OrganizationLevel::all();
            
            return $this->sendResponse($OrganizationLevel, $this->successStatus);
        }catch (\Exception $e){
            return $this->sendError(500, ['error'=> $e]);
        }
    }

    public function listFilterAndPagine(Request $request){
        $filter = $request->filter;
        $count = $request->count;
        try{
            if (strlen($filter)>0){
                $OrganizationLevel = OrganizationLevel::where('org_level_name', 'like', '%' . $filter . '%')
                            ->orWhere('org_level_desc', 'like', '%' . $filter . '%')
                            ->paginate($count);

                           
            }else{
                $OrganizationLevel = OrganizationLevel::paginate($count);
            }
            
            
            return $this->sendResponse($OrganizationLevel, $this->successStatus);
        }catch (\Exception $e){
            return $this->sendError(500, ['error'=> $e]);
        }
    }


    public function show($id){
        try{
            $oOrganizationLevel = OrganizationLevel::find($id);

            if ($oOrganizationLevel) {
                return $this->sendResponse($oOrganizationLevel, $this->successStatus);
            }else{
                return $this->sendError(404, ['error'=> 'Organization Level does not exist.']);
            }
        }catch (\Exception $e){
            return $this->sendError(500, ['error'=> $e]);
        }
    }

    public function store(StoreRequest $request){
        
        
        try{
            $oOrganizationLevel = new OrganizationLevel();
            $oOrganizationLevel->org_level_code = $request->org_level_code;
            $oOrganizationLevel->org_level_name = $request->org_level_name;
            $oOrganizationLevel->org_level_desc = $request->org_level_desc;
            $oOrganizationLevel->sorting_number = $request->sorting_number;
            $oOrganizationLevel->user_input = $request->get('userLoginId'); 
            $oOrganizationLevel->user_edit = $request->get('userLoginId'); 
            $oOrganizationLevel->save();
 
            return $this->sendResponse($oOrganizationLevel, $this->successStatus);
        }catch (\Exception $e){
            return $this->sendError(500, ['error'=> $e]);
        }
        

    }

    public function update(UpdateRequest $request,$id){
        try{
            $oOrganizationLevel = OrganizationLevel::find($id);

            if ($oOrganizationLevel) {
                $oOrganizationLevel->org_level_code = $request->org_level_code;
                $oOrganizationLevel->org_level_name = $request->org_level_name;
                $oOrganizationLevel->org_level_desc = $request->org_level_desc;
                $oOrganizationLevel->sorting_number = $request->sorting_number;
                $oOrganizationLevel->user_edit = $request->get('userLoginId'); 
                $oOrganizationLevel->save();


 

                return $this->sendResponse($oOrganizationLevel, $this->successStatus);
            }else{
                return $this->sendError(404, ['error'=> 'Organization Level does not exist.']);
            }
        }catch (\Exception $e){
            return $this->sendError(500, ['error'=> $e]);
        }
    }

    public function destroy($id){
        try{
            $oOrganizationLevel = OrganizationLevel::find($id);

            if ($oOrganizationLevel) {               
                $oOrganizationLevel->delete();
                return $this->sendResponse($oOrganizationLevel, $this->successStatus);
            }else{
                return $this->sendError(404, ['error'=> 'Organization Level does not exist.']);
            }
        }catch (\Exception $e){
            return $this->sendError(500, ['error'=> $e]);
        }
    }



}
