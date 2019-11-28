<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Model\Tenant\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Requests\User\LoginRequest;
use App\Http\Requests\User\StoreRequest;
use App\Http\Requests\User\UpdateRequest;
use Str;

class UserController extends Controller
{
    private $apiToken;
    
    public function __construct()
    {
        // Unique Token
        $this->apiToken = uniqid(base64_encode(Str::random(60)));
    }

    public function login(LoginRequest $request)
    {              
        try{
            $oUser = User::where('name',$request->name)->first();
            if ($oUser) {
                if( password_verify($request->password, $oUser->password) ) {
                    $oUser->api_token = $this->apiToken;
                    $oUser->save();
                    return $this->sendResponse($oUser, $this->successStatus);
                }else{
                    return $this->sendError(404, ['error'=> 'Invalid Username and Password']);
                }
            }else{
                return $this->sendError(404, ['error'=> 'Invalid Username and Password']);
            }
        }catch (\Exception $e){
            return $this->sendError(500, ['error'=> $e]);
        }
        
    }

    public function logout(Request $request)
    {
        try{
            $token = $request->header('tenant-token');
            $oUser = User::where('api_token',$token)->first();
            if ($oUser) {
                $oUser->api_token = null;
                $oUser->save();
                return $this->sendResponse($oUser, $this->successStatus);
            }else{
                return $this->sendError(404, ['error'=> 'User does not exist.']);
            }
        }catch (\Exception $e){
            return $this->sendError(500, ['error'=> $e]);
        }
    }

    public function index(){
      
        try{
            $lsUser = User::all();            
            return $this->sendResponse($lsUser, $this->successStatus);
        }catch (\Exception $e){
            return $this->sendError(500, ['error'=> $e]);
        }
    }

    public function listFilterAndPagine(Request $request){
        $filter = $request->filter;
        $count = $request->count;
       
        try{
            if (strlen($filter)>0){               
                $lsUser = User::where('name', 'like', '%' . $filter . '%')                   
                    ->orWhere('email', 'like', '%' . $filter . '%')                    
                    ->paginate($count);
                            
            }else{
                $lsUser = User::paginate($count);
            }

            return $this->sendResponse($lsUser, $this->successStatus);
        }catch (\Exception $e){
            return $this->sendError(500, ['error'=> $e]);
        }
       
    }

    public function show($id){
        try{
            $oUser = User::find($id);

            if ($oUser) {
                return $this->sendResponse($oUser, $this->successStatus);
            }else{
                return $this->sendError(404, ['error'=> 'User does not exist.']);
            }
        }catch (\Exception $e){
            return $this->sendError(500, ['error'=> $e]);
        }
    }

    public function store(StoreRequest $request){
        try{
            $oUser = new User();
            $oUser->name = $request->name;
            $oUser->email = $request->email;
            $oUser->password = bcrypt($request->grade);
            $oUser->save();
            return $this->sendResponse($oUser, $this->successStatus);
        }catch (\Exception $e){
            return $this->sendError(500, ['error'=> $e]);
        }
    }
    
    public function update(UpdateRequest $request,$id){
        try{
            $oUser = User::find($id);

            if ($oUser) {
                $oUser->name = $request->name;
                $oUser->email = $request->email;               
                $oUser->save();
                return $this->sendResponse($oUser, $this->successStatus);
            }else{
                return $this->sendError(404, ['error'=> 'User does not exist.']);
            }
        }catch (\Exception $e){
            return $this->sendError(500, ['error'=> $e]);
        }
    }

    public function destroy($id){
        try{
            $oUser = User::find($id);

            if ($oUser) {               
                $oUser->delete();
                return $this->sendResponse($oUser, $this->successStatus);
            }else{
                return $this->sendError(404, ['error'=> 'User does not exist.']);
            }
        }catch (\Exception $e){
            return $this->sendError(500, ['error'=> $e]);
        }
    }
}
