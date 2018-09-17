<?php

namespace App\Providers;

use App\Notifications\LosingClient;
use Illuminate\Notifications\Notification;
use Setting;
use App\Client;
use App\Notifications\LatePickup;
use App\Pickup;
use App\Shipment;
use App\User;
use App\UserTemplate;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;

class NotificationServiceProvider extends ServiceProvider
{

    protected $admins;

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->booted(function () {
            $this->admins = User::where('user_template_id', UserTemplate::where('name', 'admin')->first()->id)->get();
            $this->latePickups();
            $this->losingClients();
        });
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    public function latePickups()
    {
        $latePickups = Pickup::pending()->notAlerted()->whereDate('available_time_end', "<", now())->get();
        if ($latePickups->count()) {
            foreach ($latePickups as $latePickup) {
                /** @var Pickup $latePickup */
                $notification = new LatePickup($latePickup);
                $latePickup->update(['alerted' => true]);
                $this->notifyAdmins($notification);
            }
        }
    }

    public function losingClients()
    {
        $period = Setting::get('accounting.loyaltyDays');
        $losingClients = DB::table('shipments')
            ->join('clients', 'clients.account_number', '=', 'shipments.client_account_number')
            ->distinct()
            ->select('shipments.client_account_number')
            ->where('clients.alerted', '=', false)
            ->groupBy('shipments.client_account_number')
            ->having(DB::raw("MAX(shipments.delivery_date)"), "<=", now()->subDays($period))
            ->pluck('client_account_number');

        foreach ($losingClients as $losingClient) {
            $client = Client::find($losingClient);
            if (is_null($client)) continue;
            $notification = new LosingClient($client);
            if (is_null($notification)) continue;
            $client->update(['alerted' => true]);
            $this->notifyAdmins($notification);
        }
    }

    protected function notifyAdmins(Notification $notification)
    {
        foreach ($this->admins as $admin) {
            /** @var User $admin */
            $admin->notify($notification);
        }
    }
}
