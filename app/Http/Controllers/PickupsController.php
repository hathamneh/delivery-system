<?php

namespace App\Http\Controllers;

use App\Address;
use App\Client;
use App\Courier;
use App\Guest;
use App\Pickup;
use App\PickupStatus;
use App\Shipment;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\View;

class PickupsController extends Controller
{

    public function __construct()
    {
        View::share([
            'pageTitle' => trans('pickup.label')
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $s = $request->get('s', false);

        $pickups   = Pickup::latest('available_time_start');
        $startDate = $endDate = false;
        if (Auth::user()->isCourier()) {
            $pickups = Pickup::latest('available_time_start');
            $pickups->today()->where('courier_id', Auth::user()->courier->id);
        } elseif ($request->has('start') && $request->has('end')) {
            $startDate = Carbon::createFromTimestamp($request->get('start'));
            $endDate   = Carbon::createFromTimestamp($request->get('end'));
            $pickups->whereDate('available_time_start', '>=', $startDate)->whereDate('available_time_end', '<=', $endDate);
        }

        if ($s) {
            $pickups->search($s, $request->get('searchType', 'client'));
        }

        $statuses = PickupStatus::all();

        return view('pickups.index')->with([
            'pickups'         => $pickups->simplePaginate(),
            'startDate'       => $startDate,
            'endDate'         => $endDate,
            's'               => $s,
            'statuses'        => $statuses,
            'statusesOptions' => self::statusesOptions($statuses),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $couriers = Courier::all();
        $addresses = Address::all();
        return view('pickups.create')->with([
            'couriers'  => $couriers,
            'addresses'  => $addresses,
            'pageTitle' => trans('pickup.create')
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $pickup = new Pickup;
        try {
            if ($request->has('is_guest') && $request->get('is_guest') === "1") {
                Guest::findOrCreateByNationalId($request->get('client_national_id'), [
                    'trade_name'    => $request->get('guest_name'),
                    'phone_number'  => $request->get('phone_number'),
                    'country' => $request->get('guest_country'),
                    'city'    => $request->get('guest_city'),
                    'address_id'    => $request->get('guest_address_id'),
                    'address_detailed'    => $request->get('guest_address_detailed'),
                ]);
            } else {
                $pickup->client()->associate(Client::findOrFail($request->get('client_account_number')));
            }
            $pickup->courier()->associate(Courier::findOrFail($request->get('courier_id')));

        } catch (\Exception $exception) {
            logger($exception->getTraceAsString());
            return $exception->getMessage();
        }

        $pickup->fill($request->toArray());

        $day                          = $request->get('available_day');
        $start                        = $request->get('time_start');
        $end                          = $request->get('time_end');
        $startDate                    = Carbon::createFromFormat("j/n/Y h:ia", $day . " " . $start);
        $endDate                      = Carbon::createFromFormat("j/n/Y h:ia", $day . " " . $end);
        $pickup->available_time_start = $startDate;
        $pickup->available_time_end   = $endDate;
        $pickup->save();

        $waybills = $request->get('waybills', []);
        if (count($waybills)) {
            foreach ($waybills as $waybill) {
                $pickup->shipments()->attach(Shipment::waybill($waybill)->first());
            }
        }

        return redirect()->route('pickups.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Pickup $pickup
     * @return \Illuminate\Http\Response
     */
    public function show(Pickup $pickup)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Request $request
     * @param  \App\Pickup $pickup
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Pickup $pickup)
    {

        $couriers = Courier::all();
        $pickup->load('shipments');
        return view('pickups.edit')->with([
            'pickup'   => $pickup,
            'couriers' => $couriers
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Pickup $pickup
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Pickup $pickup)
    {
        $pickup->courier()->associate(Courier::findOrFail($request->get('courier_id')));
        $pickup->fill($request->toArray());
        $day       = $request->get('available_day');
        $start     = $request->get('time_start');
        $end       = $request->get('time_end');
        $startDate = Carbon::createFromFormat("j/n/Y h:ia", $day . " " . $start);
        $endDate   = Carbon::createFromFormat("j/n/Y h:ia", $day . " " . $end);

        $pickup->available_time_start = $startDate;
        $pickup->available_time_end   = $endDate;
        $pickup->save();

        return redirect()->route('pickups.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Pickup $pickup
     * @return \Illuminate\Http\Response
     */
    public function destroy(Pickup $pickup)
    {
        try {
            $pickup->delete();
        } catch (\Exception $ex) {
        }
        return back();
    }

    /**
     * @param Request $request
     * @param Pickup $pickup
     * @return \Illuminate\Http\Response
     */
    public function actions(Request $request, Pickup $pickup)
    {
        $request->validate([
            'status'         => 'required|exists:pickup_statuses,name',
            'available_day'  => 'required_if:status,rescheduled,ready',
            'time_start'     => 'required_if:status,rescheduled,ready',
            'time_end'       => 'required_if:status,rescheduled,ready',
            'actualPackages' => 'required_if:status,collected',
        ]);

        $status = PickupStatus::name($request->get('status'))->first();
        $pickup->pickupStatus()->associate($status);
        $pickup->status_note            = $request->get('reason', "");
        $pickup->notes_external         = $request->get('notes', "");
        $pickup->actual_packages_number = null;
        switch ($status->name) {
            case "rescheduled":
                $pickup->status_note = $request->get('rescheduled_by', "");
            case "ready":
                $day       = $request->get('available_day');
                $start     = $request->get('time_start');
                $end       = $request->get('time_end');
                $startDate = Carbon::createFromFormat("j/n/Y h:ia", $day . " " . $start);
                $endDate   = Carbon::createFromFormat("j/n/Y h:ia", $day . " " . $end);

                $pickup->available_time_start = $startDate;
                $pickup->available_time_end   = $endDate;
                break;
            case "collected":
                if($request->get('prepaid_cash') !== $pickup->prepaid_cash)
                    return back()->withErrors([
                        "Prepaid cash provided is wrong!"
                    ]);
                $pickup->actual_packages_number = $request->get('actualPackages');
                break;
        }
        $pickup->save();

        return back();
    }

    public static function statusesOptions(Collection $statuses)
    {
        $completed = $setAvailableTime = $setAddress = $select = $notesRequired = [];
        foreach ($statuses as $status) {
            /** @var PickupStatus $status */
            if (isset($status->options['set_address']) && $status->options['set_address']) $setAddress[] = $status->name;
            if (isset($status->options['set_available_time']) && $status->options['set_available_time']) $setAvailableTime[] = $status->name;
            if (isset($status->options['notes_required']) && $status->options['notes_required']) $notesRequired[] = $status->name;
            if ((isset($status->options['prepaid_cash']) && $status->options['prepaid_cash'])
                || isset($status->options['actual_packages']) && $status->options['actual_packages']) $completed[] = $status->name;
            if (isset($status->options['select']) && $status->options['select']) $select[] = $status;
        }
        return [
            'completed'        => $completed,
            'setAvailableTime' => $setAvailableTime,
            'setAddress'       => $setAddress,
            'notesRequired'    => $notesRequired,
            'select'           => $select,
        ];
    }
}
