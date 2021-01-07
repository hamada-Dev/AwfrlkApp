<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        App\Models\User::create([
            'name' => 'Super',
            'lastName' => 'Admin',
            'email' => 'super@eg.com',
            'phone' => '010',
            'gender' => 1,
            'group' => 'admin',
            'ssn' => 3040506060,
            'adress' => '15 street minia',
            'password' => bcrypt('12345'),
            'area_id' =>  1,
            'api_token' => hash('md5', 'user'),
            'user_code' => str_random(5),
        ]);
        App\Models\User::create([
            'name' => 'employee',
            'lastName' => 'eeeee',
            'email' => 'emp@eg.com',
            'phone' => '011',
            'gender' => 1,
            'group' => 'emp',
            'ssn' => 3040506070,
            'adress' => '15 street minia',
            'password' => bcrypt('12345'),
            'area_id' =>  1,
            'api_token' => hash('md5', 'user'),
            'user_code' => str_random(5),
        ]);
        App\Models\User::create([
            'name' => 'delivery',
            'lastName' => 'dd',
            'email' => 'delivery@eg.com',
            'phone' => '012',
            'gender' => 1,
            'group' => 'delivery',
            'ssn' => 30405080,
            'adress' => '15 street minia',
            'password' => bcrypt('12345'),
            'area_id' =>  1,
            'api_token' => hash('md5', 'user'),
            'user_code' => str_random(5),
        ]); 
        
        App\Models\User::create([
            'name' => 'user',
            'lastName' => 'uu',
            'email' => 'user@eg.com',
            'phone' => '015',
            'gender' => 1,
            'group' => 'user',
            'ssn' => 304050220,
            'adress' => '15 street minia',
            'password' => bcrypt('12345'),
            'area_id' =>  1,
            'api_token' => hash('md5', 'user'),
            'user_code' => str_random(5),
        ]);
    } // end of run
} //end of seeder
