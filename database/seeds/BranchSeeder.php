<?php

use Illuminate\Database\Seeder;

class BranchSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Branch::create([
            "name"    => "Gardens",
            "address" => "",
            "is_main" => true
        ]);
    }
}
