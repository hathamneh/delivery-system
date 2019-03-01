<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{


    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = App\UserTemplate::where("name", '=', 'admin')->first();

        $this->rootUser($admin);

    }


    public function rootUser($template)
    {
        $rootUser                 = new \App\User;
        $rootUser->username       = "root";
        $rootUser->email          = "himoath@gmail.com";
        $rootUser->password       = Hash::make('rootstartx');
        $rootUser->remember_token = str_random(10);
        $rootUser->template()->associate($template);
        $rootUser->save();
    }

}
