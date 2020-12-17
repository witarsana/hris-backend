<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Main\Company;

class CompanyController extends Controller
{
    public function companyAccess(Request $request){
        $requestHost = parse_url($request->headers->get('origin'),  PHP_URL_HOST);
        $reArr = explode('.',$requestHost);
        $companyName = $reArr[0];
        $oCompany = Company::where('company_name',$companyName)->get();
        return $this->sendResponse($oCompany, $this->successStatus);
    }
}
