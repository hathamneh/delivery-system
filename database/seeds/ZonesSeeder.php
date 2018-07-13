<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ZonesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $oldZones = DB::connection('mysql2')->table('zones')
            ->select('*')->where('zombie', 0)->get();
        foreach ($oldZones as $oldZone) {
            $zone = \App\Zone::create([
                'name' => $oldZone->name,
                'base_weight' => $oldZone->base_weight,
                'charge_per_unit' => $oldZone->charge_per_unit,
                'extra_fees_per_unit' => $oldZone->extra_fees_per_unit,
            ]);
            $oldAddresses = DB::connection('mysql2')->table('zones_addresses')
                ->select('*')->where('zone_id', $oldZone->id)
                ->where('zombie', 0)->get();
            foreach ($oldAddresses as $oldAddress) {
                $zone->addresses()->create([
                    'name' => $oldAddress->name,
                    'sameday_price' => $oldAddress->sameday_p,
                    'scheduled_price' => $oldAddress->schedule_p,
                ]);
            }
        }
    }
}
