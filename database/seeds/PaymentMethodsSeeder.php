<?php

use Illuminate\Database\Seeder;

class PaymentMethodsSeeder extends Seeder
{

    private $paymentMethods = [
        'cash',
        'bank_deposit',
        'bank_transfer',
        'exchange_shop_transfer',
        'zain_cash',
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $paymentMethods = [];
        foreach ($this->paymentMethods as $paymentMethod) {
            $paymentMethods[] = \App\PaymentMethod::create(['name' => $paymentMethod])->id;
        }
        foreach (\App\Client::all() as $client) {
            $client->paymentMethods()->sync($paymentMethods);
        }
    }
}
