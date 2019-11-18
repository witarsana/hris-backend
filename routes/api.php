<?php

use Illuminate\Http\Request;


//for unauthorized route
Route::get('/',function(){
    $res = [
        "status"  => false,
        "message" => 401,
        "data"    => "Unauthorized"
    ];
    return response()->json($res);   
})->name('unauthorized');

//route for thoose who pass oauth 
Route::middleware('auth:api')->group(function () {    
    //route for thoose who subdomain not registered in companies 
    Route::get('/unregis',function(){
        $res = [
            "status"  => false,
            "message" => 404,
            "data"    => "Unregistered Company"
        ];
        return response()->json($res);
    })->name('unregistered');

    Route::get('/needlogin',function(){
        $res = [
            "status"  => false,
            "message" => 401,
            "data"    => "Login required"
        ];
        return response()->json($res);
    })->name('needlogin');

    #ROUTE FOR LOGIN
    
    
    Route::middleware(['tenant'])->group(function () {           
        #TENANT ROUTE
        Route::post('/tenantlogin','Api\UserController@login');
        Route::middleware(['apitenant'])->group(function () { 
            #ROUTE FOR PKTP STATUS
            Route::get('/ptkpstatus','Api\PtkpStatusController@index');
            Route::get('/ptkpstatus/filter','Api\PtkpStatusController@listFilterAndPagine');
            Route::get('/ptkpstatus/{id}','Api\PtkpStatusController@show');
            Route::post('/ptkpstatus','Api\PtkpStatusController@store');
            Route::post('/ptkpstatus/{id}/update','Api\PtkpStatusController@update');
            Route::delete('/ptkpstatus/{id}','Api\PtkpStatusController@destroy');

            #ROUTE FOR BPJS RATE
            Route::get('/bpjsrate','Api\BpjsRateController@index');
            Route::get('/bpjsrate/filter','Api\BpjsRateController@listFilterAndPagine');
            Route::get('/bpjsrate/{id}','Api\BpjsRateController@show');
            Route::post('/bpjsrate','Api\BpjsRateController@store');
            Route::post('/bpjsrate/{id}/update','Api\BpjsRateController@update');
            Route::delete('/bpjsrate/{id}','Api\BpjsRateController@destroy');

            #ROUTE FOR PEGAWAI 
            Route::get('/pegawai','Api\PegawaiController@index');
            Route::get('/pegawai/filter','Api\PegawaiController@listFilterAndPagine');
            Route::get('/pegawai/{id}','Api\PegawaiController@show');
            Route::get('/pegawai/{id}/photoid','Api\PegawaiController@photoId');
            Route::get('/pegawai/{id}/photo-object','Api\PegawaiController@photoByObject');
            Route::post('/pegawai','Api\PegawaiController@store');
            Route::post('/pegawai/{id}/update','Api\PegawaiController@update');
            Route::delete('/pegawai/{id}','Api\PegawaiController@destroy');

            #ROUTE FOR EDUCATION
            Route::get('/education','Api\EducationController@index');
            Route::get('/education/filter','Api\EducationController@listFilterAndPagine');
            Route::get('/education/{id}','Api\EducationController@show');
            Route::post('/education','Api\EducationController@store');
            Route::post('/education/{id}/update','Api\EducationController@update');
            Route::delete('/education/{id}','Api\EducationController@destroy');

            #ROUTE FOR FAMILY
            Route::get('/family','Api\FamilyController@index');
            Route::get('/family/filter','Api\FamilyController@listFilterAndPagine');
            Route::get('/family/{id}','Api\FamilyController@show');
            Route::get('/family/{id}/photoid','Api\FamilyController@photoId');
            Route::get('/family/{id}/photo-object','Api\FamilyController@photoByObject');
            Route::post('/family','Api\FamilyController@store');
            Route::post('/family/{id}/update','Api\FamilyController@update');
            Route::delete('/family/{id}','Api\FamilyController@destroy');

            #ROUTE FOR JOB HISTORY
            Route::get('/jobhistory','Api\JobHistoryController@index');
            Route::get('/jobhistory/filter','Api\JobHistoryController@listFilterAndPagine');
            Route::get('/jobhistory/{id}','Api\JobHistoryController@show');
            Route::post('/jobhistory','Api\JobHistoryController@store');
            Route::post('/jobhistory/{id}/update','Api\JobHistoryController@update');
            Route::delete('/jobhistory/{id}','Api\JobHistoryController@destroy');

            #ROUTE FOR POSITION HISTORY
            Route::get('/positionhistory','Api\PositionHistoryController@index');
            Route::get('/positionhistory/filter','Api\PositionHistoryController@listFilterAndPagine');
            Route::get('/positionhistory/{id}','Api\PositionHistoryController@show');
            Route::post('/positionhistory','Api\PositionHistoryController@store');
            Route::post('/positionhistory/{id}/update','Api\PositionHistoryController@update');
            Route::delete('/positionhistory/{id}','Api\PositionHistoryController@destroy');
        
            #ROUTE FOR USER
            Route::get('/tenantlogout','Api\UserController@logout');
            Route::get('/user','Api\UserController@index');
            Route::get('/user/filter','Api\UserController@listFilterAndPagine');
            Route::get('/user/{id}','Api\UserController@show');
            Route::post('/user','Api\UserController@store');
            Route::post('/user/{id}/update','Api\UserController@update');
            Route::delete('/user/{id}','Api\UserController@destroy');

            #ROUTE FOR MASTER TRAINING TYPE
            Route::get('/mastertrainingtype','Api\MasterTrainingTypeController@index');
            Route::get('/mastertrainingtype/filter','Api\MasterTrainingTypeController@listFilterAndPagine');
            Route::get('/mastertrainingtype/{id}','Api\MasterTrainingTypeController@show');
            Route::post('/mastertrainingtype','Api\MasterTrainingTypeController@store');
            Route::post('/mastertrainingtype/{id}/update','Api\MasterTrainingTypeController@update');
            Route::delete('/mastertrainingtype/{id}','Api\MasterTrainingTypeController@destroy');

            #ROUTE FOR TRAINING HISTORICAL
            Route::get('/traininghistorical','Api\TrainingHistoricalController@index');
            Route::get('/traininghistorical/filter','Api\TrainingHistoricalController@listFilterAndPagine');
            Route::get('/traininghistorical/{id}','Api\TrainingHistoricalController@show');
            Route::post('/traininghistorical','Api\TrainingHistoricalController@store');
            Route::post('/traininghistorical/{id}/update','Api\TrainingHistoricalController@update');
            Route::delete('/traininghistorical/{id}','Api\TrainingHistoricalController@destroy');

            #ROUTE FOR SALARY HISTORICAL
            Route::get('/salaryhistorical','Api\SalaryHistoricalController@index');
            Route::get('/salaryhistorical/filter','Api\SalaryHistoricalController@listFilterAndPagine');
            Route::get('/salaryhistorical/{id}','Api\SalaryHistoricalController@show');
            Route::post('/salaryhistorical','Api\SalaryHistoricalController@store');
            Route::post('/salaryhistorical/{id}/update','Api\SalaryHistoricalController@update');
            Route::delete('/salaryhistorical/{id}','Api\SalaryHistoricalController@destroy');

            #ROUTE FOR LEAVES HISTORICAL
            Route::get('/leavehistorical','Api\LeaveHistoricalController@index');
            Route::get('/leavehistorical/filter','Api\LeaveHistoricalController@listFilterAndPagine');
            Route::get('/leavehistorical/{id}','Api\LeaveHistoricalController@show');
            Route::post('/leavehistorical','Api\LeaveHistoricalController@store');
            Route::post('/leavehistorical/{id}/update','Api\LeaveHistoricalController@update');
            Route::post('/leavehistorical/{id}/approved','Api\LeaveHistoricalController@approve');
            Route::delete('/leavehistorical/{id}','Api\LeaveHistoricalController@destroy');

            #ROUTE APPRAISAL MASTER DETAIL
            Route::get('/appraisalmasterdetail','Api\AppraisalMasterDetailController@index');
            Route::get('/appraisalmasterdetail/filter','Api\AppraisalMasterDetailController@listFilterAndPagine');
            Route::get('/appraisalmasterdetail/{id}','Api\AppraisalMasterDetailController@show');
            Route::post('/appraisalmasterdetail','Api\AppraisalMasterDetailController@store');
            Route::post('/appraisalmasterdetail/{id}/update','Api\AppraisalMasterDetailController@update');
            Route::delete('/appraisalmasterdetail/{id}','Api\AppraisalMasterDetailController@destroy');

            #ROUTE APPRAISAL HEADER HISTORICAL
            Route::get('/appraisalheaderhistorical','Api\AppraisalHeaderHistoricalController@index');
            Route::get('/appraisalheaderhistorical/filter','Api\AppraisalHeaderHistoricalController@listFilterAndPagine');
            Route::get('/appraisalheaderhistorical/{id}','Api\AppraisalHeaderHistoricalController@show');
            Route::post('/appraisalheaderhistorical','Api\AppraisalHeaderHistoricalController@store');
            Route::post('/appraisalheaderhistorical/{id}/update','Api\AppraisalHeaderHistoricalController@update');
            Route::delete('/appraisalheaderhistorical/{id}','Api\AppraisalHeaderHistoricalController@destroy');

            #ROUTE APPRAISAL DETAIL HISTORICAL
            Route::get('/appraisaldetailhistorical','Api\AppraisalDetailHistoricalController@index');
            Route::get('/appraisaldetailhistorical/filter','Api\AppraisalDetailHistoricalController@listFilterAndPagine');
            Route::get('/appraisaldetailhistorical/{id}','Api\AppraisalDetailHistoricalController@show');
            Route::post('/appraisaldetailhistorical','Api\AppraisalDetailHistoricalController@store');
            Route::post('/appraisaldetailhistorical/{id}/update','Api\AppraisalDetailHistoricalController@update');
            Route::delete('/appraisaldetailhistorical/{id}','Api\AppraisalDetailHistoricalController@destroy');

             #ROUTE SANCTION HISTORICAL
             Route::get('/sanctionhistorical','Api\SanctionHistoricalController@index');
             Route::get('/sanctionhistorical/filter','Api\SanctionHistoricalController@listFilterAndPagine');
             Route::get('/sanctionhistorical/{id}','Api\SanctionHistoricalController@show');
             Route::post('/sanctionhistorical','Api\SanctionHistoricalController@store');
             Route::post('/sanctionhistorical/{id}/update','Api\SanctionHistoricalController@update');
             Route::delete('/sanctionhistorical/{id}','Api\SanctionHistoricalController@destroy');

             #ROUTE ORGANIZATION MASTER DATA 
             Route::get('/organizationmasterdata','Api\OrganizationMasterDataController@index');
             Route::get('/organizationmasterdata/filter','Api\OrganizationMasterDataController@listFilterAndPagine');
             Route::get('/organizationmasterdata/{id}','Api\OrganizationMasterDataController@show');
             Route::post('/organizationmasterdata','Api\OrganizationMasterDataController@store');
             Route::post('/organizationmasterdata/{id}/update','Api\OrganizationMasterDataController@update');
             Route::delete('/organizationmasterdata/{id}','Api\OrganizationMasterDataController@destroy');

             #ROUTE SALARY MASTER DATA
             Route::get('/salarymasterdata','Api\SalaryMasterDataController@index');
             Route::get('/salarymasterdata/filter','Api\SalaryMasterDataController@listFilterAndPagine');
             Route::get('/salarymasterdata/{id}','Api\SalaryMasterDataController@show');
             Route::post('/salarymasterdata','Api\SalaryMasterDataController@store');
             Route::post('/salarymasterdata/{id}/update','Api\SalaryMasterDataController@update');
             Route::delete('/salarymasterdata/{id}','Api\SalaryMasterDataController@destroy');

             #ROUTE SALARY OF ATTENDANCE
             Route::get('/salaryofattendance','Api\SalaryOfAttendanceController@index');
             Route::get('/salaryofattendance/filter','Api\SalaryOfAttendanceController@listFilterAndPagine');
             Route::get('/salaryofattendance/{id}','Api\SalaryOfAttendanceController@show');
             Route::post('/salaryofattendance','Api\SalaryOfAttendanceController@store');
             Route::post('/salaryofattendance/{id}/update','Api\SalaryOfAttendanceController@update');
             Route::delete('/salaryofattendance/{id}','Api\SalaryOfAttendanceController@destroy');

             #ROUTE EMPLOYEE ORGANIZATION 
             Route::get('/employeeorganization','Api\EmployeeOrganizationController@index');
             Route::get('/employeeorganization/filter','Api\EmployeeOrganizationController@listFilterAndPagine');
             Route::get('/employeeorganization/{id}','Api\EmployeeOrganizationController@show');
             Route::post('/employeeorganization','Api\EmployeeOrganizationController@store');
             Route::post('/employeeorganization/{id}/update','Api\EmployeeOrganizationController@update');
             Route::delete('/employeeorganization/{id}','Api\EmployeeOrganizationController@destroy');

             #ROUTE ATTENDANCE 
             Route::get('/attendance','Api\AttendanceController@index');
             Route::get('/attendance/filter','Api\AttendanceController@listFilterAndPagine');
             Route::get('/attendance/{id}','Api\AttendanceController@show');
             Route::post('/attendance','Api\AttendanceController@store');
             Route::post('/attendance/{id}/update','Api\AttendanceController@update');
             Route::delete('/attendance/{id}','Api\AttendanceController@destroy');

             #WORKSHIFT MASTER DATA
             Route::get('/workshiftmasterdata','Api\WorkshiftMasterDataController@index');
             Route::get('/workshiftmasterdata/filter','Api\WorkshiftMasterDataController@listFilterAndPagine');
             Route::get('/workshiftmasterdata/{id}','Api\WorkshiftMasterDataController@show');
             Route::post('/workshiftmasterdata','Api\WorkshiftMasterDataController@store');
             Route::post('/workshiftmasterdata/{id}/update','Api\WorkshiftMasterDataController@update');
             Route::delete('/workshiftmasterdata/{id}','Api\WorkshiftMasterDataController@destroy');

             #WORKSHIFT CHANGE
             Route::get('/workshiftchange','Api\WorkshiftChangeController@index');
             Route::get('/workshiftchange/filter','Api\WorkshiftChangeController@listFilterAndPagine');
             Route::get('/workshiftchange/{id}','Api\WorkshiftChangeController@show');
             Route::post('/workshiftchange','Api\WorkshiftChangeController@store');
             Route::post('/workshiftchange/{id}/update','Api\WorkshiftChangeController@update');
             Route::delete('/workshiftchange/{id}','Api\WorkshiftChangeController@destroy');

             #SPL HEADER
             Route::get('/splheader','Api\SplHeaderController@index');
             Route::get('/splheader/filter','Api\SplHeaderController@listFilterAndPagine');
             Route::get('/splheader/{id}','Api\SplHeaderController@show');
             Route::post('/splheader','Api\SplHeaderController@store');
             Route::post('/splheader/{id}/update','Api\SplHeaderController@update');
             Route::post('/splheader/{id}/approval','Api\SplHeaderController@approval');
             Route::delete('/splheader/{id}','Api\SplHeaderController@destroy');

             #SPL DETAIL
             Route::get('/spldetail','Api\SplDetailController@index');
             Route::get('/spldetail/filter','Api\SplDetailController@listFilterAndPagine');
             Route::get('/spldetail/{id}','Api\SplDetailController@show');
             Route::post('/spldetail','Api\SplDetailController@store');
             Route::post('/spldetail/{id}/update','Api\SplDetailController@update');
             Route::post('/spldetail/{id}/approval','Api\SplDetailController@approval');
             Route::delete('/spldetail/{id}','Api\SplDetailController@destroy');

             #IREGULAR INCOME
             Route::get('/iregularincome','Api\IregularIncomeController@index');
             Route::get('/iregularincome/filter','Api\IregularIncomeController@listFilterAndPagine');
             Route::get('/iregularincome/{id}','Api\IregularIncomeController@show');
             Route::post('/iregularincome','Api\IregularIncomeController@store');
             Route::post('/iregularincome/{id}/update','Api\IregularIncomeController@update');
             Route::post('/iregularincome/{id}/approval','Api\IregularIncomeController@approval');
             Route::delete('/iregularincome/{id}','Api\IregularIncomeController@destroy');

             #IREGULAR DEDUCTION
             Route::get('/iregulardeduction','Api\IregularDeductionController@index');
             Route::get('/iregulardeduction/filter','Api\IregularDeductionController@listFilterAndPagine');
             Route::get('/iregulardeduction/{id}','Api\IregularDeductionController@show');
             Route::post('/iregulardeduction','Api\IregularDeductionController@store');
             Route::post('/iregulardeduction/{id}/update','Api\IregularDeductionController@update');
             Route::post('/iregulardeduction/{id}/approval','Api\IregularDeductionController@approval');
             Route::delete('/iregulardeduction/{id}','Api\IregularDeductionController@destroy');

             #NATIONAL HOLIDAY
             Route::get('/nationalholiday','Api\NationalHolidayController@index');
             Route::get('/nationalholiday/filter','Api\NationalHolidayController@listFilterAndPagine');
             Route::get('/nationalholiday/{id}','Api\NationalHolidayController@show');
             Route::post('/nationalholiday','Api\NationalHolidayController@store');
             Route::post('/nationalholiday/{id}/update','Api\NationalHolidayController@update');
             Route::post('/nationalholiday/{id}/approval','Api\NationalHolidayController@approval');
             Route::delete('/nationalholiday/{id}','Api\NationalHolidayController@destroy');

             #MEDICAL CLAIM EMPLOYEE
             Route::get('/medicalclaimemployee','Api\MedicalClaimEmployeeController@index');
             Route::get('/medicalclaimemployee/filter','Api\MedicalClaimEmployeeController@listFilterAndPagine');
             Route::get('/medicalclaimemployee/{id}','Api\MedicalClaimEmployeeController@show');
             Route::post('/medicalclaimemployee','Api\MedicalClaimEmployeeController@store');
             Route::post('/medicalclaimemployee/{id}/update','Api\MedicalClaimEmployeeController@update');
             Route::post('/medicalclaimemployee/{id}/approval','Api\MedicalClaimEmployeeController@approval');
             Route::delete('/medicalclaimemployee/{id}','Api\MedicalClaimEmployeeController@destroy');

             #MEDICAL CHECK UP EMPLOYEE
             Route::get('/medicalcheckupemployee','Api\MedicalCheckUpEmployeeController@index');
             Route::get('/medicalcheckupemployee/filter','Api\MedicalCheckUpEmployeeController@listFilterAndPagine');
             Route::get('/medicalcheckupemployee/{id}','Api\MedicalCheckUpEmployeeController@show');
             Route::post('/medicalcheckupemployee','Api\MedicalCheckUpEmployeeController@store');
             Route::post('/medicalcheckupemployee/{id}/update','Api\MedicalCheckUpEmployeeController@update');
             Route::post('/medicalcheckupemployee/{id}/approval','Api\MedicalCheckUpEmployeeController@approval');
             Route::delete('/medicalcheckupemployee/{id}','Api\MedicalCheckUpEmployeeController@destroy');

             #LOAN EMPLOYEE
             Route::get('/loanemployee','Api\LoanEmployeeController@index');
             Route::get('/loanemployee/filter','Api\LoanEmployeeController@listFilterAndPagine');
             Route::get('/loanemployee/{id}','Api\LoanEmployeeController@show');
             Route::post('/loanemployee','Api\LoanEmployeeController@store');
             Route::post('/loanemployee/{id}/update','Api\LoanEmployeeController@update');
             Route::post('/loanemployee/{id}/approval','Api\LoanEmployeeController@approval');
             Route::delete('/loanemployee/{id}','Api\LoanEmployeeController@destroy');

             #LOAN INSTALLMENTS HISTORY
             Route::get('/loaninstallmentshistory','Api\LoanInstallmentsHistoryController@index');
             Route::get('/loaninstallmentshistory/filter','Api\LoanInstallmentsHistoryController@listFilterAndPagine');
             Route::get('/loaninstallmentshistory/{id}','Api\LoanInstallmentsHistoryController@show');
             Route::post('/loaninstallmentshistory','Api\LoanInstallmentsHistoryController@store');
             Route::post('/loaninstallmentshistory/{id}/update','Api\LoanInstallmentsHistoryController@update');
             Route::post('/loaninstallmentshistory/{id}/approval','Api\LoanInstallmentsHistoryController@approval');
             Route::delete('/loaninstallmentshistory/{id}','Api\LoanInstallmentsHistoryController@destroy');

             #SETTING HEADER
             Route::get('/settingheader','Api\SettingHeaderController@index');
             Route::get('/settingheader/filter','Api\SettingHeaderController@listFilterAndPagine');
             Route::get('/settingheader/{id}','Api\SettingHeaderController@show');
             Route::post('/settingheader','Api\SettingHeaderController@store');
             Route::post('/settingheader/{id}/update','Api\SettingHeaderController@update');
             Route::post('/settingheader/{id}/approval','Api\SettingHeaderController@approval');
             Route::delete('/settingheader/{id}','Api\SettingHeaderController@destroy');

             #SETTING DETAIL
             Route::get('/settingdetail','Api\SettingDetailController@index');
             Route::get('/settingdetail/filter','Api\SettingDetailController@listFilterAndPagine');
             Route::get('/settingdetail/{id}','Api\SettingDetailController@show');
             Route::post('/settingdetail','Api\SettingDetailController@store');
             Route::post('/settingdetail/{id}/update','Api\SettingDetailController@update');
             Route::post('/settingdetail/{id}/approval','Api\SettingDetailController@approval');
             Route::delete('/settingdetail/{id}','Api\SettingDetailController@destroy');
        });
    });
});
