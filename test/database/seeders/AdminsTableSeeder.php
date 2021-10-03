<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;


class AdminsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('admins')->insert([
            'username'=>'Ali Rahhal',
            'email'=>'alih.rahhal@hotmail.com',
            'password'=>Hash::make('abc@123')
        ]);
    }
}
