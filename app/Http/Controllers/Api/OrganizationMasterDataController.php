<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Tenant\OrganizationMasterData;
use App\Http\Requests\OrganizationMasterData\StoreRequest;
use App\Http\Requests\OrganizationMasterData\UpdateRequest;


class OrganizationMasterDataController extends Controller
{
    public function index(){
        try {
           /* $lsOrganizationMasterData = OrganizationMasterData::whereNull('dependent_to')
                                        ->with('children','user_i:id,name','user_e:id,name')->orderBy('sorting_number', 'ASC')->get();     */

             $lsOrganizationMasterData = OrganizationMasterData::whereNull('dependent_to')
                                        ->with('org_level:org_level_code,org_level_name')
                                        ->with('children','user_i:id,name','user_e:id,name')
                                        ->orderBy('sorting_number', 'ASC')
                                        ->get(); 

            return $this->sendResponse($lsOrganizationMasterData, $this->successStatus);
        } catch (\Exception $e) {
            return $this->sendError(500, ['error'=> $e]);
        }
    }

    public function show($id){
        try{
            $oOrganizationMasterData = OrganizationMasterData::with('children','user_i:id,name','user_e:id,name')->orderBy('sorting_number', 'ASC')->find($id);

            if ($oOrganizationMasterData) {
                return $this->sendResponse($oOrganizationMasterData, $this->successStatus);
            }else{
                return $this->sendError(404, ['error'=> 'Organization Master Data does not exist.']);
            }
        }catch (\Exception $e){
            return $this->sendError(500, ['error'=> $e]);
        }
    }

    public function store(StoreRequest $request){
        try{
            $oOrganizationMasterData = new OrganizationMasterData();
            $oOrganizationMasterData->org_code = $request->org_code;
            $oOrganizationMasterData->org_name = $request->org_name;
            $oOrganizationMasterData->dependent_to = $request->dependent_to;
            $oOrganizationMasterData->org_level_code = $request->org_level_code;
            $oOrganizationMasterData->dependent_status = $request->dependent_status;
            $oOrganizationMasterData->mandatory_status = $request->mandatory_status;
            $oOrganizationMasterData->user_management_status = $request->user_management_status;
            $oOrganizationMasterData->sorting_number = $request->sorting_number;
            $oOrganizationMasterData->user_input = $request->get('userLoginId'); 
            $oOrganizationMasterData->user_edit = $request->get('userLoginId'); 
            $oOrganizationMasterData->save();
            return $this->sendResponse($oOrganizationMasterData, $this->successStatus);
        }catch (\Exception $e){
            return $this->sendError(500, ['error'=> $e]);
        }
    }

    public function update(UpdateRequest $request,$id){
        try{
            $oOrganizationMasterData = OrganizationMasterData::find($id);

            if ($oOrganizationMasterData) {
                //$oOrganizationMasterData->org_code = $request->org_code;
                $oOrganizationMasterData->org_name = $request->org_name;
                $oOrganizationMasterData->dependent_to = $request->dependent_to;
                $oOrganizationMasterData->org_level_code = $request->org_level_code;
                $oOrganizationMasterData->dependent_status = $request->dependent_status;
                $oOrganizationMasterData->mandatory_status = $request->mandatory_status;
                $oOrganizationMasterData->user_management_status = $request->user_management_status;
                $oOrganizationMasterData->sorting_number = $request->sorting_number;
                $oOrganizationMasterData->user_edit = $request->get('userLoginId'); 
                $oOrganizationMasterData->save();
                return $this->sendResponse($oOrganizationMasterData, $this->successStatus);
            }else{
                return $this->sendError(404, ['error'=> 'Organization Master Data does not exist.']);
            }
        }catch (\Exception $e){
            return $this->sendError(500, ['error'=> $e]);
        }
    }

    public function destroy($id){
        try {
            $oOrganizationMasterData = OrganizationMasterData::find($id);
            if ($oOrganizationMasterData) {
                $oOrganizationMasterData->delete();
                return $this->sendResponse($oOrganizationMasterData, $this->successStatus);
            }else{
                return $this->sendError(404, ['error'=> 'Organization Master Data does not exist.']);
            }
        } catch (\Exception $e) {
            return $this->sendError(500, ['error'=> $e]);
        
        }
    }
}
