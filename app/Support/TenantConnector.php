<?php

namespace App\Support;

use App\Model\Main\Company;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

trait TenantConnector {
   
   /**
    * Switch the Tenant connection to a different company.   
    */
   public function reconnect(Company $company) {     
      // Erase the tenant connection, thus making Laravel get the default values all over again.
      DB::purge('tenant');
      
      // Make sure to use the database name we want to establish a connection.
      Config::set('database.connections.tenant.host', $company->db_host);
      Config::set('database.connections.tenant.database', $company->company_id);
      Config::set('database.connections.tenant.username', $company->db_user);
      Config::set('database.connections.tenant.password', $company->db_password);
      
      // Rearrange the connection data
      DB::reconnect('tenant');

   }
   
}