<?php

namespace App\Console\Commands\Dev;

use Illuminate\Console\Command;
use App\Model\Main\Company;
use DB;
use Ramsey\Uuid\Uuid;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Artisan;

class MakeCompanyCommand extends Command
{
    
    protected $signature = 'make:company';
    protected $description = 'Make a new company and migrate the database';
    public function __construct()
    {
        parent::__construct();
    }

    
    public function handle()
    {
            
        $companyId  = Uuid::uuid4()->getHex();
        $companyName = $this->ask("Company Name");
        $companyEmail = $this->ask("Company Email");
        //$companyPassword = $this->secret("Company Password");
        $companyPassword = $companyName;
        $dbHost = $this->ask("DB Host");
        $dbPort = $this->ask("DB Port");
        $dbUser = $this->ask("DB User");    
        $dbPassword = $this->secret("Password");
        //$dbPassword = $companyName;

        if ($this->confirm('Do you wish to continue?')) {
            try {              
                DB::beginTransaction();

                $objCompany = new Company();
                $objCompany->company_id = $companyId;
                $objCompany->company_name = $companyName;
                $objCompany->company_email = $companyEmail;
                $objCompany->company_password = bcrypt($companyPassword);
                $objCompany->db_host = $dbHost;
                $objCompany->db_port = $dbPort;
                $objCompany->db_user = $dbUser;
                $objCompany->db_password = $dbPassword; 
                $objCompany->user_input = "";
                $objCompany->user_edit ="";
                $objCompany->user_delete ="";
                $objCompany->save();
                
                $query = "CREATE DATABASE IF NOT EXISTS $companyId ;";

                DB::statement($query);

                DB::commit();
                
                //connect to database tenant
                DB::purge('tenant');

                //set tenant connection configuration 
                Config::set('database.connections.tenant.host', $dbHost);
                Config::set('database.connections.tenant.database', $companyId);
                Config::set('database.connections.tenant.username', $dbUser);
                Config::set('database.connections.tenant.password', $dbPassword);
                
                // Rearrange the connection data
                DB::reconnect('tenant');
                
                // Ping the database. This will throw an exception in case the database does not exists or the connection fails
                Schema::connection('tenant')->getConnection()->reconnect();
                
                //migrate tenant database
                Artisan::call('migrate', [
                    '--path'     => "database/migrations/tenant",
                    '--database' => 'tenant'
                ]); 
            
                Artisan::call('db:seed', [
                    '--class'     => "DatabaseSeeder",
                    '--database' => 'tenant'
                ]); 
                                   

            } catch (\Exception $e) {
                DB::rollBack();
                print($e);
            }
        }
    }
}
