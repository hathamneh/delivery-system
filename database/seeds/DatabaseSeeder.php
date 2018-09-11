<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UsersTableSeeder::class);
        $this->call(StatusesSeeder::class);
//        $this->call(ZonesSeeder::class);
//        $this->call(ClientSeeder::class);
//        $this->call(CourierSeeder::class);
    }
}
