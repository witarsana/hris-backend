<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Tenant\NationalHoliday;
use App\Http\Requests\NationalHoliday\StoreRequest;
use App\Http\Requests\NationalHoliday\UpdateRequest;

class NationalHolidayController extends Controller
{
    public function index(){
        try{
            $lsNationalHoliday = NationalHoliday::with('user_i','user_e')->get();            
            return $this->sendResponse($lsNationalHoliday, $this->successStatus);
        }catch (\Exception $e){
            return $this->sendError(500, ['error'=> $e]);
        }
    
    }

    public function listFilterAndPagine(Request $request){
        $filter = $request->filter;
        $count = $request->count;
        try{
            if (strlen($filter)>0){
                $lsNationalHoliday = NationalHoliday::with('user_i','user_e')
                    ->where('holiday', 'like', '%' . $filter . '%')
                    ->orWhere('description', 'like', '%' . $filter . '%')
                    ->paginate($count);
            }else{
                $lsNationalHoliday = NationalHoliday::with('user_i','user_e')->paginate($count);
            }
            
            
            return $this->sendResponse($lsNationalHoliday, $this->successStatus);
        }catch (\Exception $e){
            return $this->sendError(500, ['error'=> $e]);
        }
    }

    public function show($id){
        try{
            $oNationalHoliday = NationalHoliday::with('user_i','user_e')->find($id);

            if ($oNationalHoliday) {
                return $this->sendResponse($oNationalHoliday, $this->successStatus);
            }else{
                return $this->sendError(404, ['error'=> 'National Holiday does not exist.']);
            }
        }catch (\Exception $e){
            return $this->sendError(500, ['error'=> $e]);
        }
    }

    public function store(StoreRequest $request){
        try{
            $oNationalHoliday = new NationalHoliday();
            $oNationalHoliday->holiday = $request->holiday;
            $oNationalHoliday->description = $request->description;
            $oNationalHoliday->user_input = $request->get('userLoginId');
            $oNationalHoliday->user_edit = $request->get('userLoginId');
            $oNationalHoliday->save();
            return $this->sendResponse($oNationalHoliday, $this->successStatus);
        }catch (\Exception $e){
            return $this->sendError(500, ['error'=> $e]);
        }
    }

    public function update(UpdateRequest $request,$id){
        try{
            $oNationalHoliday = NationalHoliday::find($id);

            if ($oNationalHoliday) {
                $oNationalHoliday->holiday = $request->holiday;
                $oNationalHoliday->description = $request->description;
                $oNationalHoliday->user_edit = $request->get('userLoginId');
                $oNationalHoliday->save();
                return $this->sendResponse($oNationalHoliday, $this->successStatus);
            }else{
                return $this->sendError(404, ['error'=> 'National Holiday does not exist.']);
            }
        }catch (\Exception $e){
            return $this->sendError(500, ['error'=> $e]);
        }
    }

    public function destroy($id){
        try{
            $oNationalHoliday = NationalHoliday::find($id);

            if ($oNationalHoliday) {               
                $oNationalHoliday->delete();
                return $this->sendResponse($oNationalHoliday, $this->successStatus);
            }else{
                return $this->sendError(404, ['error'=> 'National Holiday does not exist.']);
            }
        }catch (\Exception $e){
            return $this->sendError(500, ['error'=> $e]);
        }
    }
}
