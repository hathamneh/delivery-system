<?php

namespace App\Http\Controllers;

use App\Branch;
use App\Courier;
use App\Http\Requests\StoreCourierRequest;
use App\Status;
use App\User;
use App\Zone;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CouriersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $couriers              = Courier::all();
        $haveWorkTodayCouriers = Courier::haveWorkToday()->get();
        return view('couriers.index')->with([
            'couriers'              => $couriers,
            'pageTitle'             => trans('courier.label'),
            'haveWorkTodayCouriers' => $haveWorkTodayCouriers
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $zones = Zone::all();
        return view('couriers.create')->with([
            'zones'     => $zones,
            'pageTitle' => trans('courier.create')
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCourierRequest $request)
    {
        $courier               = new Courier;
        $courier->name         = $request->get('name');
        $courier->email        = $request->get('email');
        $courier->password     = User::generatePassword();
        $courier->phone_number = $request->get('phone_number');
        $courier->address      = $request->get('address');
        $courier->category     = $request->get('category');
        $courier->notes        = $request->get('notes');

        $courier->save();

        $courier->createUser();
        $courier->zones()->sync($request->get('zones', []));
        $courier->uploadAttachments($request->file('courier_files'));

        return redirect()->route('couriers.index')->with([
            'alert' => (object)[
                'type' => 'success',
                'msg'  => trans('courier.created')
            ]
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param Request $request
     * @param  \App\Courier $courier
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Courier $courier)
    {
        $data = [
            'courier'   => $courier,
            'tab'       => "statistics",
            'pageTitle' => $courier->name,
        ];
        $this->appendStatsData($data, $courier, $request);
        return view('couriers.show')->with($data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Courier $courier
     * @return \Illuminate\Http\Response
     */
    public function edit(Courier $courier)
    {
        $zones = Zone::all();
        return view('couriers.edit', [
            'tab'       => "edit",
            'courier'   => $courier,
            'zones'     => $zones,
            'pageTitle' => trans('courier.edit')
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Courier $courier
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Courier $courier)
    {
        $courier->name         = $request->get('name');
        $courier->email        = $request->get('email');
        $courier->phone_number = $request->get('phone_number');
        $courier->address      = $request->get('address');
        $courier->category     = $request->get('category');
        $courier->notes        = $request->get('notes');
        $courier->save();

        $courier->zones()->sync($request->get('zones', []));
        $courier->uploadAttachments($request->file('courier_files'));

        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Courier $courier
     * @return \Illuminate\Http\Response
     */
    public function destroy(Courier $courier)
    {
        $alert = $alert = (object)[
            'type' => 'success',
            'msg'  => trans('courier.deleted')
        ];
        try {
            $courier->delete();
        } catch (\Exception $e) {
            $alert = (object)[
                'type' => 'danger',
                'msg'  => trans('courier.failed')
            ];
        }
        return redirect()->route('couriers.index')->with([
            'alert' => $alert,
        ]);
    }

    protected function appendStatsData(array &$data, Courier $courier, Request $request)
    {
        $start_time        = strtotime("-29 days");
        $end_time          = time();
        $start             = $request->get('start', $start_time);
        $end               = $request->get('end', $end_time);
        $data['startDate'] = $start;
        $data['endDate']   = $end;
        try {
            $begin              = Carbon::createFromTimestamp($request->get('start', $start));
            $until              = Carbon::createFromTimestamp($request->get('end', $end));
            $data['statistics'] = $courier->statistics($begin, $until);
        } catch (\Exception $ex) {
            $begin              = Carbon::createFromTimestamp($start_time);
            $until              = Carbon::createFromTimestamp($end_time);
            $data['statistics'] = $courier->statistics($begin, $until);
            $data['alert']      = (object)[
                'type' => 'danger',
                'msg'  => "Date range provided is invalid"
            ];
        }
        $data['daterange'] = $begin->toFormattedDateString() . ' - ' . $until->toFormattedDateString();
    }

    /**
     * @param Request $request
     * @param Courier $courier
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function inventory(Request $request, Courier $courier)
    {
        if (!auth()->user()->isAdmin()) abort(401, 'This action is unauthorized.');

        $data = [
            'shipments'        => $courier->shipments()->untilToday()->get(),
            'courier'          => $courier,
            "pageHeadingClass" => "reporting-heading",
            'branches'         => Branch::all(),
            'statuses'         => $this->getStatuses(),
            'statuses_keyed'   => Status::all()->keyBy('name')->all(),
            'pageTitle'        => trans('inventory.couriers'),
            'sidebarCollapsed' => true
        ];

        return view("couriers.inventory")->with($data);
    }

    public function getStatuses()
    {
        /** @var User $user */
        $user       = auth()->user();
        $processing = ["processing"];
        $in_transit = ["in_transit"];
        $delivered  = ["delivered"];
        if ($user->isCourier()) {
            $processing[] = "courier";
            $in_transit[] = "courier";
            $delivered[]  = "courier";
        }
        return [
            'processing' => Status::group($processing)->get(),
            'in_transit' => Status::group($in_transit)->get(),
            'delivered'  => Status::group($delivered)->get(),
        ];
    }
}
