<?php

namespace App\Console\Commands\Dev;

use Illuminate\Console\Command;
use App\Model\Main\Company;
use DB;
use Ramsey\Uuid\Uuid;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Artisan;

class RemoveCompanyCommand extends Command
{
    
    protected $signature = 'remove:company';
    protected $description = 'Delete selected company by name';
    public function __construct()
    {
        parent::__construct();
    }

    
    public function handle()
    {
            
        
        $companyName = $this->ask("Company Name");
        
        if ($this->confirm('Do you wish to continue?')) {
            try {              
                DB::beginTransaction();

                $objCompany = Company::where("company_name",$companyName)->first();
                
                $databaseName = $objCompany->company_id;
                $objCompany->delete();
                
                $query = "DROP DATABASE $databaseName ;";

                DB::statement($query);

                DB::commit();

            } catch (\Exception $e) {
                DB::rollBack();
                print($e);
            }
        }
    }
}
