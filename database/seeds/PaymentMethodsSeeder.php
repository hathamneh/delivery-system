<?php

use App\Client;
use App\PaymentMethod;
use Illuminate\Database\Seeder;

class PaymentMethodsSeeder extends Seeder
{

    private $paymentMethods = [
        'cash',
        'bank_deposit',
        'bank_transfer',
        'exchange_shop_transfer',
        'zain_cash',
        'cash_from_office'
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        PaymentMethod::truncate();

        $paymentMethods = [];
        foreach ($this->paymentMethods as $paymentMethod) {
            $paymentMethods[] = PaymentMethod::create(['name' => $paymentMethod])->id;
        }
    }
}
