<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CourierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $oldCouriers = DB::connection('mysql2')->table('couriers')
            ->select('*')->where('zombie', 0)->get();
        foreach ($oldCouriers as $oldCourier) {
            $courier = new \App\Courier;
            $courier->name = $oldCourier->name;
            $courier->phone_number = $oldCourier->phone_number;
            $courier->address = $oldCourier->address;
            $courier->category = $oldCourier->category;
            $courier->password = $oldCourier->password;
            $courier->notes = $oldCourier->notes;
            $oldZone = DB::connection('mysql2')->table('zones')
                ->select('name')->where('zombie', 0)
                ->where('id', $oldCourier->zone_id)->first();
            $zone = \App\Zone::where('name', $oldZone->name)->first();
            $courier->zone()->associate($zone);
            $courier->save();
            $courier->createUser();
        }
    }
}
