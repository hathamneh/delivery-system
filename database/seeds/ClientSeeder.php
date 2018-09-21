<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ClientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {


        $oldCients = DB::connection('mysql2')->table('clients')
            ->select('*')->where('zombie', 0)->get();
        foreach ($oldCients as $oldCient) {
            $client = new \App\Client;
            $client->name = $oldCient->name;
            $client->trade_name = $oldCient->trade_name;
            $client->password = $oldCient->password;
            $client->phone_number = $oldCient->phone_number;
            $isUsed = \App\Client::where('email', $oldCient->email)->count();
            $client->email = $isUsed ? null : $oldCient->email;
            $client->address_country = $oldCient->address_country;
            $client->address_city = $oldCient->address_city;
            $client->address_sub = $oldCient->address_sub;
            $client->address_maps = $oldCient->address_maps;
            $client->address_pickup_text = $oldCient->address_pickup_text;
            $client->address_pickup_maps = $oldCient->address_pickup_maps;
            $client->url_facebook = $oldCient->facebook_url;
            $client->sector = $oldCient->sector;
            $client->category = $oldCient->category;
            $client->bank_name = $oldCient->bank_info_bank_name;
            $client->bank_account_number = $oldCient->bank_info_branch;
            $client->bank_holder_name = $oldCient->bank_info_client_name;
            $client->bank_iban = $oldCient->bank_info_iban;

            $oldZone = DB::connection('mysql2')->table('zones')
                ->select('name')->where('zombie', 0)
                ->where('id', $oldCient->zone_id)->first();
            $zone = \App\Zone::where('name', $oldZone->name)->first();
            $client->zone()->associate($zone);

            $client->save();
            $client->createUser();

        }
    }
}
