<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Tenant\OrganizationMasterData;
use App\Model\Tenant\OrganizationLevel;
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
    
    public function generateDynamicOrganizationData($SelectedData){
         try {
          

            $OrganizationLevelValue_arr = OrganizationLevel::select('org_level_code','org_level_name')->orderBy('id')->get();
            $OrganizationLevelCounter = count($OrganizationLevelValue_arr);            
            //========================================================================================

           

            $Data1 = '"ComboCount":"'.$OrganizationLevelCounter.'",';

            $Counter_l = 1;
            
            $CLV = "";
            $CLC = "";  
            foreach($OrganizationLevelValue_arr as $OL){
                if($Counter_l >= $OrganizationLevelCounter){
                    $CLV .= '"'.$OL->org_level_code.'"';
                    $CLC .= '"'.$OL->org_level_name.'"';
                }
                else{
                    $CLV .= '"'.$OL->org_level_code.'"'.",";
                    $CLC .= '"'.$OL->org_level_name.'"'.",";
                }

               $Counter_l++;
            }

            $Data2 = '"ComboLabelValue":['.$CLV.'],';
            $Data3 = '"ComboLabelCaption":['.$CLC.'],';
            $Data4 = '"ComboName":['.$CLV.'],';

            //========================================================================================
            //$OrganizationMasterData_arr = OrganizationMasterData::orderBy('org_level_code')->get()->toSql();
            $query1 = OrganizationMasterData::select('dependent_to','org_name','org_level_code');
            $OrganizationMasterData_arr = OrganizationMasterData::distinct()->select('organization_master_data.org_level_code as org_level_code1','data1.org_level_code as org_level_code2')
                                            ->leftjoinSub($query1,'data1',function($join){
                                                $join->on('organization_master_data.org_code','=','data1.dependent_to');
                                            })
                                            ->whereNotNull('data1.org_level_code')
                                            ->get();
                                            //->toSql();
             //echo  $OrganizationMasterData_arr;
            $OrganizationMasterDataCounter = count($OrganizationMasterData_arr);
            //========================================================================================
            //die();

            $CMDV = "";
            $CMDC = "";

            $Counter_md = 1;
            foreach($OrganizationMasterData_arr as $OMD){
                if($Counter_md >= $OrganizationMasterDataCounter){
                    $CMDV .= '{"relation":['.'"'.$OMD->org_level_code1.'"'.','.'"'.$OMD->org_level_code2.'"'.']}';                    
                }
                else{
                    $CMDV .= '{"relation":['.'"'.$OMD->org_level_code1.'"'.','.'"'.$OMD->org_level_code2.'"'.']},';
                }               
               $Counter_md++;
            }

            $Data5 = '"ComboRelation":['.$CMDV.'],';
            $Data6 = '"ComboSelected" :[],';
            

            //===========================================================================================
            $OrganizationLevelJoin_arr = OrganizationLevel::select('organization_level.org_level_code',
                                                                   'organization_level.org_level_name',
                                                                   'organization_master_data.org_code',
                                                                   'organization_master_data.org_name')
                                        ->leftJoin('organization_master_data', 'organization_level.org_level_code', '=', 'organization_master_data.org_level_code')
                                        ->OrderBy('organization_level.id','asc')
                                        ->OrderBy('organization_master_data.org_name','asc')
                                        ->get();
                                        //->toSql();
            $OrganizationLevelJoinCounter = count($OrganizationLevelJoin_arr);
           
            $temp = "";
            $CLJV = "";
            foreach($OrganizationLevelJoin_arr as $OLJ){
                if($temp == ""){ $temp = $OLJ->org_level_code;
                    $CLJV = '{"combo":[';
                }
                if($temp == $OLJ->org_level_code){
                    $CLJV .= '{"value" : '.'"'.$OLJ->org_code.'"'.',"caption" : '.'"'.$OLJ->org_name.'"'.'},';                           
                }
                else{                    
                    $CLJV .= 'enddata]},';                   
                    $temp = $OLJ->org_level_code;
                    $CLJV .= '{"combo":[';                   
                    $CLJV .= '{"value" : '.'"'.$OLJ->org_code.'"'.',"caption" : '.'"'.$OLJ->org_name.'"'.'},';                          
                }  
            }
            $CLJV .= 'enddata]}';
            $CLJV = str_replace(",enddata","",$CLJV);

            
            //echo $CLJV;
            //die();


            $Data7 = '"DataComb" :['.$CLJV.'],';

            //===========================================================================================
            $query1 = OrganizationMasterData::select('dependent_to','org_name','org_level_code');
            $query2 = OrganizationMasterData::select('*');
            $OrganizationRelation_arr = OrganizationMasterData::distinct()
                                        ->select('organization_master_data.org_level_code as org_level_code1',
                                                 'data1.org_level_code as org_level_code2',
                                                 'data2.org_code as org_code1',
                                                 'data2.org_name as org_name1',
                                                 'data3.org_code as org_code2',
                                                 'data3.org_name as org_name2'
                                            )
                                        ->leftjoinSub($query1,'data1',function($join){
                                                $join->on('organization_master_data.org_code','=','data1.dependent_to');
                                         })
                                        ->leftjoinSub($query2,'data2',function($join){
                                                $join->on('organization_master_data.org_level_code','=','data2.org_level_code');
                                         })
                                        ->leftjoinSub($query2,'data3',function($join){
                                                $join->on('data1.org_level_code','=','data3.org_level_code')
                                                     ->on('data3.dependent_to','=','data2.org_code');
                                         })
                                        ->whereNotNull('data1.org_level_code')
                                        ->whereNotNull('data3.org_code')
                                        ->orderBy('organization_master_data.org_level_code')
                                        ->orderBy('data2.org_name')
                                        ->orderBy('data3.org_name')
                                        ->get();
                                        //->toSql();
             //echo  $OrganizationRelation_arr;
             //die();
            $OrganizationRelationCounter = count($OrganizationRelation_arr);


        $temp = "";
        $temp2 = "";
        $CR = "";
        $counter = 1;
        $counter2 = 1;
       
            foreach($OrganizationRelation_arr as $OR){
                if($temp == "" ){ 

                    $temp = $OR->org_level_code1;
                    if($temp2 == "" ) $temp = $OR->org_code1;
                    //echo "{combo:["."\n";
                    $CR .= '{"combo":[';
                }


                    if(($temp == $OR->org_level_code1) and  ($temp2 == $OR->org_code1)){
                         //echo "{value : "."'".$OR->org_code2."'".",caption : "."'".$OR->org_name2."'"."},"."\n"; 
                          $CR .= '{"value" : '.'"'.$OR->org_code2.'"'.',"caption" : '.'"'.$OR->org_name2.'"'.'},';                           
                    
                    }
                    else{                    
                        if($counter > 1) {
                            //echo  "enddata]},"."\n"; 
                             $CR .= 'enddata]},' ;
                        } 
                        if($temp != $OR->org_level_code1 and $counter2 > 1){
                            //echo  "enddata]},"."\n"; 
                            //echo "{combo:["."\n";
                            $CR .= 'enddata]},' ;
                            $CR .= '{"combo":[';
                            
                        }
                        $counter2++;

                        $temp = $OR->org_level_code1;
                        $temp2 =  $OR->org_code1;
                        //echo  "{value: "."'".$OR->org_code1."'".", subcombo :["."\n";  
                        $CR .= '{"value": '.'"'.$OR->org_code1.'"'.', "subcombo" :[';                 
                        //echo  "{value : "."'".$OR->org_code2."'".",caption : "."'".$OR->org_name2."'"."},"."\n";  
                        $CR .= '{"value" : '.'"'.$OR->org_code2.'"'.',"caption" : '.'"'.$OR->org_name2.'"'.'},';                        
                    }

                    $counter++;
             
            }
        //echo "enddata]}"."\n";
        $CR .= 'enddata]}';
        //echo  "enddata]}"."\n"; 
        $CR .= ']}';
        $CR = str_replace(",enddata","",$CR);
        $CR = str_replace("enddata]},","",$CR);

        //die("$CR");

        //die();

            $Data8 = '"DataCombRelation" :['.$CR.']';



            //$DataDO = "{\"success\": true,";
            $DataDO = "{";
            $DataDO .= $Data1;
            $DataDO .= $Data2;
            $DataDO .= $Data3;
            $DataDO .= $Data4;
            $DataDO .= $Data5;
            $DataDO .= $Data6;
            $DataDO .= $Data7;
            $DataDO .= $Data8;
            $DataDO .= "}";
            //return $DataDO;

            //return $OrganizationMasterData_arr;
            //return $OrganizationLevelValue_arr;
            return $this->sendResponse($DataDO, $this->successStatus);
        } catch (\Exception $e) {
            return $this->sendError(500, ['error'=> $e]);
        }

       
    }
}
