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
    }
}
