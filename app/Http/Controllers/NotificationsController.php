<?php

namespace App\Http\Controllers;

use Setting;
use App\Client;
use App\Notifications\LatePickup;
use App\Notifications\LosingClient;
use App\Notifications\LowDilveryCost;
use App\Notifications\MaxRejectedShipments;
use App\Pickup;
use App\Shipment;
use App\User;
use App\UserTemplate;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class NotificationsController extends Controller
{

    protected $admins;

    public function index(Request $request)
    {
        /** @var User $user */
        $user = $request->user();

        /** @var Collection $unread */
        $unreadCount = $user->unreadNotifications->count();
        /** @var Collection $notys */
        $notifications = $user->notifications()->latest()->limit(15)->get();
        return [
            'unreadCount' => $unreadCount,
            'notifications'      => $notifications->map(function($item) { return $item->toArray(); })
        ];
    }

    public function refresh()
    {
        try {
            $this->admins = User::where('user_template_id', UserTemplate::where('name', 'admin')->first()->id)->get();
            $this->latePickups();
            $this->losingClients();
        } catch (\Exception $e) {
        }
    }

    public function clear()
    {
        /** @var User $user */
        $user = Auth::user();

        foreach ($user->unreadNotifications as $unreadNotification) {
            $unreadNotification->markAsRead();
        }
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

    public function lowDeliveryCostClients()
    {
        $clients = Client::all();
        foreach ($clients as $client) {
            /** @var Client $client */
            if ($client->max_returned_shipments > 0) {
                $returnedShipments = $client->shipments()->statusIn(['cancelled', 'rejected', 'returned'])
                    ->whereDate('created_at', '>=', Carbon::now()->startOfMonth())->count();
                if ($returnedShipments >= $client->max_returned_shipments) {
                    $this->notifyAdmins(new MaxRejectedShipments($client));
                }
            }
            if ($client->min_delivery_cost > 0) {
                $sum = 0;

                $shipments = $client->shipments()->whereDate('created_at', '>=', Carbon::now()->startOfMonth())->get();
                foreach ($shipments as $shipment) {
                    /** @var Shipment $shipment */
                    $sum += $shipment->delivery_cost;
                }
                if ($sum < $client->min_delivery_cost) {
                    $this->notifyAdmins(new LowDilveryCost($client));
                }
            }
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
