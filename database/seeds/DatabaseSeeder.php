<?php

use Illuminate\Database\Seeder;
use Ramsey\Uuid\Uuid;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        DB::table('users')->insert([
            'name' => 'admin',
            'email' =>'admin@example.com',
            'password' => bcrypt('admin'),
        ]);
        
        //BPJS Rates
        DB::table('bpjs_rates')->insert([
            'code' => Uuid::uuid4()->getHex(),
            'description' => 'BPJS Rates',
            'jhtp' => 3.7,
            'jhtk' => 2,
            'jk'=>0,
            'jkk'=>0.89,
            'jpk_lajang' =>0,
            'jpk_nikah'=>0,
            'bpjskesp' =>4,
            'bpjskesk' =>1,
            'max_salary_pension' =>0,
            'max_salary_medical' =>8000000,
            'pension_company' => 1,
            'pension_employees' =>2,
        ]);
        
        //PTKP STATUS
        DB::table('ptkp_status')->insert([
            'ptkp_code' => Uuid::uuid4()->getHex(),
            'description' => 'TK/0',
            'status' => 1,
            'dependents' => 0,
            'ptkp_value'=>54000000
        ]);
        DB::table('ptkp_status')->insert([
            'ptkp_code' => Uuid::uuid4()->getHex(),
            'description' => 'TK/1',
            'status' => 1,
            'dependents' => 1,
            'ptkp_value'=>58500000
        ]);
        DB::table('ptkp_status')->insert([
            'ptkp_code' => Uuid::uuid4()->getHex(),
            'description' => 'TK/2',
            'status' => 1,
            'dependents' => 2,
            'ptkp_value'=>63000000
        ]);
        DB::table('ptkp_status')->insert([
            'ptkp_code' => Uuid::uuid4()->getHex(),
            'description' => 'TK/3',
            'status' => 1,
            'dependents' => 3,
            'ptkp_value'=>67500000
        ]);
        DB::table('ptkp_status')->insert([
            'ptkp_code' => Uuid::uuid4()->getHex(),
            'description' => 'K/0',
            'status' => 2,
            'dependents' => 0,
            'ptkp_value'=>58500000
        ]);
        DB::table('ptkp_status')->insert([
            'ptkp_code' => Uuid::uuid4()->getHex(),
            'description' => 'K/1',
            'status' => 2,
            'dependents' => 1,
            'ptkp_value'=>63000000
        ]);
        DB::table('ptkp_status')->insert([
            'ptkp_code' => Uuid::uuid4()->getHex(),
            'description' => 'K/2',
            'status' => 2,
            'dependents' => 2,
            'ptkp_value'=>67500000
        ]);
        DB::table('ptkp_status')->insert([
            'ptkp_code' => Uuid::uuid4()->getHex(),
            'description' => 'K/3',
            'status' => 2,
            'dependents' => 3,
            'ptkp_value'=>72000000
        ]);
        DB::table('ptkp_status')->insert([
            'ptkp_code' => Uuid::uuid4()->getHex(),
            'description' => 'HB/0',
            'status' => 5,
            'dependents' => 0,
            'ptkp_value'=>54000000
        ]);
        DB::table('ptkp_status')->insert([
            'ptkp_code' => Uuid::uuid4()->getHex(),
            'description' => 'HB/1',
            'status' => 5,
            'dependents' => 1,
            'ptkp_value'=>58500000
        ]);
        DB::table('ptkp_status')->insert([
            'ptkp_code' => Uuid::uuid4()->getHex(),
            'description' => 'HB/2',
            'status' => 5,
            'dependents' => 2,
            'ptkp_value'=>63000000
        ]);
        DB::table('ptkp_status')->insert([
            'ptkp_code' => Uuid::uuid4()->getHex(),
            'description' => 'HB/3',
            'status' => 5,
            'dependents' => 3,
            'ptkp_value'=>67500000
        ]);


        
    }
}
