<?php

namespace App\Http\Controllers;

use App\Address;
use App\Branch;
use App\Client;
use App\Courier;
use App\Guest;
use App\Http\Requests\StoreShipmentRequest;
use App\Policies\ShipmentPolicy;
use App\ReturnedShipment;
use App\Service;
use App\Shipment;
use App\Status;
use App\SubStatus;
use App\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Activitylog\Models\Activity;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class ShipmentController extends Controller
{

    /**
     * @var ShipmentFilters
     */
    private $shipmentFilters;

    public function __construct()
    {
        $this->shipmentFilters = new ShipmentFilters();
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index(Request $request)
    {
        $this->authorize('index', Shipment::class);

        /** @var User $user */
        $user = Auth::user();

        if ($user->isCourier())
            $shipmentsQuery = $user->courier->shipments()->untilToday();
        elseif ($user->isClient())
            $shipmentsQuery = $user->client->shipments();
        else
            $shipmentsQuery = Shipment::query();

        if ($request->has('start'))
            $shipmentsQuery->whereDate('created_at', '>=', $request->get('start'));
        if ($request->has('end'))
            $shipmentsQuery->whereDate('created_at', '<=', $request->get('end'));


        $requestFilters = $request->get('filters', []);
        $appliedFilters = $this->shipmentFilters->applyFilters($shipmentsQuery, $requestFilters);
        $shipments      = $shipmentsQuery->get();

        $pageTitle = trans('shipment.all');
        if ($this->shipmentFilters->filters['types'] == ['normal', 'guest'])
            $pageTitle = trans('shipment.normal');
        elseif ($this->shipmentFilters->filters['types'] == ['returned'])
            $pageTitle = trans('shipment.returned');
        elseif($request->get('today') === '1')
            $pageTitle = trans('shipment.today_shipments');

        return view('shipments.index', [
            'shipments'        => $shipments,
            'filtersData'      => $this->shipmentFilters->filtersData(),
            'applied'          => $appliedFilters,
            'pageTitle'        => $pageTitle . " (" . $shipments->count() . ")",
            'sidebarCollapsed' => true
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param string $type
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function create($type = "legacy")
    {
        $this->authorize('create', Shipment::class);

        $suggestedWaybill      = (new Shipment)->generateNextWaybill();
        $suggestedDeliveryDate = $this->suggestedDeliveryDate();
        $statuses              = Status::whereIn('name', ['picked_up', 'received'])->get();
        $couriers              = Courier::all();
        $addresses             = Address::all();
        $services              = Service::all();
        $data                  = [
            'statuses'              => $statuses,
            'suggestedWaybill'      => $suggestedWaybill['waybill'],
            'suggestedDeliveryDate' => $suggestedDeliveryDate->format('d/m/Y'),
            'couriers'              => $couriers,
            'addresses'             => $addresses,
            'services'              => $services,
            'pageTitle'             => trans('shipment.new')
        ];
        switch ($type) {
            case "legacy":
                return view('shipments.create', $data);
            case "wizard":
            default:
                return view('shipments.wizard.create', $data);

        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreShipmentRequest $request
     * @return Shipment
     * @throws \Exception
     */
    public function store(StoreShipmentRequest $request)
    {
        $this->authorize('create', Shipment::class);

        $suggestedWaybill = (new Shipment)->generateNextWaybill();
        $clientData       = $request->get('shipment_client');

        $shipment = new Shipment;
        if ($clientData['type'] == 'guest') {
            $shipment->type = 'guest';
        }

        // make relations
        $shipment->saveClient($clientData);
        $shipment->address()->associate(Address::findOrFail($request->get('address_from_zones')));
        $shipment->status()->associate(Status::findOrFail($request->get('status')));
        // save form data
        $newWaybill = $request->get('waybill');
        if ($suggestedWaybill['waybill'] == $newWaybill) {
            $shipment->waybill_index = $suggestedWaybill['index'];
        }
        $shipment->waybill = $newWaybill;
        $this->addShipmentDetails($shipment, $request);
        $this->addDeliveryDetails($shipment, $request);
        // Money calculations
        $shipment->gatherPriceInformation();

        if ($request->get('custom_price', false)) {
            $shipment->total_price = $request->get('total_price');
        }

        $shipment->push();

        $services_ids = $request->get('services', []);
        $shipment->attachServices($services_ids);

        return redirect()->route('shipments.show', ['shipment' => $shipment]);
    }

    /**
     * Display the specified resource.
     *
     * @param Shipment $shipment
     * @param string $tab
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function show(Shipment $shipment, $tab = "status")
    {
        $this->authorize('view', $shipment);

        /** @var User $user */
        $user     = auth()->user();
        $shipment = $shipment->type == "returned" ? ReturnedShipment::find($shipment->id) : $shipment;
        $data     = [
            'shipment'  => $shipment->load('status'),
            'tab'       => $tab,
            'pageTitle' => trans('shipment.info'),
        ];
        if ($tab == "actions") {
            $processing = ["processing"];
            $in_transit = ["in_transit"];
            $delivered  = ["delivered"];
            if ($user->isCourier()) {
                $processing[] = "courier";
                $in_transit[] = "courier";
                $delivered[]  = "courier";
            }
            if ($shipment->type == "returned") {
                $processing[] = "returned";
                $in_transit[] = "returned";
                $delivered[]  = "returned";
            }
            $data['statuses']     = [
                'processing' => Status::group($processing)->get(),
                'in_transit' => Status::group($in_transit)->get(),
                'delivered'  => Status::group($delivered)->get(),
            ];
            $notDeliveredStatuses = Status::whereJsonContains("groups", ['in_transit'])->whereJsonDoesntContain('groups', ['pending']);
            if ($user->isCourier())
                $notDeliveredStatuses->whereJsonContains("groups", ['courier']);
            $data['not_delivered_statuses'] = $notDeliveredStatuses->get();
            $data['returned_statuses']      = Status::whereIn('name', ['rejected', 'cancelled'])->get();
            $data['branches']               = Branch::all();
        } elseif ($tab == "status") {
            if ($shipment instanceof ReturnedShipment)
                $data['log'] = Activity::forSubject(Shipment::find($shipment->id))->get();
            else
                $data['log'] = Activity::forSubject($shipment)->get();

        }
        return view('shipments.show', $data);
    }

    /**
     * @param Shipment $shipment
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function print(Shipment $shipment)
    {
        $this->authorize('view', $shipment);

        return view('shipments.print')->with([
            'shipment' => $shipment
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Shipment $shipment
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit(Shipment $shipment)
    {
        $this->authorize('update', $shipment);

        $statuses  = Status::whereIn('name', ['picked_up', 'received'])->get();
        $couriers  = Courier::all();
        $addresses = Address::all();
        $services  = Service::all();
        return view('shipments.show', [
            'shipment'  => $shipment,
            'tab'       => 'edit',
            'statuses'  => $statuses,
            'couriers'  => $couriers,
            'addresses' => $addresses,
            'services'  => $services,
            'pageTitle' => trans('shipment.edit')
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param Shipment $shipment
     * @param string $tab
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(Request $request, Shipment $shipment)
    {
        $this->authorize('update', $shipment);

        $tab = $request->get('tab');
        switch ($tab) {
            case "delivery":
                $this->addShipmentDetails($shipment, $request);
                if ($request->has('services')) {
                    $shipment->attachServices($request->get('services'));
                }
                $shipment->save();

                return redirect()->route("shipments.edit", ['shipment' => $shipment]);
                break;
            case "details":
                $this->addDeliveryDetails($shipment, $request);
                try {
                    if ($request->get('address_from_zones') != $shipment->address_id)
                        $shipment->address()->associate(Address::findOrFail($request->get('address_from_zones')));
                } catch (\Exception $e) {
                }
                try {
                    if ($request->get('courier') != $shipment->courier_id)
                        $shipment->courier()->associate(Courier::findOrFail($request->get('courier')));
                } catch (\Exception $e) {
                }
                $shipment->save();
                return redirect()->route("shipments.edit", ['shipment' => $shipment]);
                break;
            case "status":
                $status = Status::name($request->get('status'))->first();
                $shipment->status()->associate($status);
                if ($status->name = 'consignee_rescheduled') {
                    $newDeliveryDate         = Carbon::createFromFormat("d/m/Y", $request->get('delivery_date'));
                    $shipment->delivery_date = $newDeliveryDate;
                }
                $shipment->status_notes = $request->get('status_notes');
                $shipment->save();
                return redirect()->route("shipments.show", ['shipment' => $shipment, 'tab' => 'actions']);
                break;
            default:
                throw new BadRequestHttpException("Shipment update tab is not set");
        }

    }

    /**
     * @param Request $request
     * @param Shipment $shipment
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function makeReturn(Request $request, Shipment $shipment)
    {
        $this->authorize('update', $shipment);

        $request->validate([
            "status" => "required,exists:statuses,name"
        ]);
        $new    = ReturnedShipment::createFrom($shipment, [
            'delivery_date' => Carbon::createFromFormat("d/m/Y", $request->get('delivery_date'))
        ]);
        $status = Status::name($request->get('original_status'))->first();
        $shipment->status()->associate($status);
        $status_notes = "";
        if ($request->has("notes")) {
            $notes = $request->get("notes");
            foreach ($notes as $name => $value) {
                $status_notes .= strtoupper(trans("shipment.statuses_options.$name")) . ": " . $value . "\n";
            }
        }
        $status_notes             .= $request->get('external_notes');
        $shipment->status_notes   = $status_notes;
        $shipment->external_notes = $status_notes;
        $shipment->save();

        return redirect()->route('shipments.show', ['shipment' => $new]);
    }

    /**
     * @param Request $request
     * @param Shipment $shipment
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function updateDelivery(Request $request, Shipment $shipment)
    {
        $this->authorize('update', $shipment);
        $isReturned = $shipment->isReturnedShipment();
        if ($isReturned)
            $request->validate([
                'status'        => 'required',
                'delivery_date' => 'required_if:status,rescheduled'
            ]);
        else
            $request->validate([
                'status'        => 'required',
                'actual_paid'   => 'required_if:status,delivered,rejected,collected_from_office',
                'delivery_date' => 'required_if:status,rescheduled'
            ]);
        $status = $request->get('status');
        if ($status == "delivered") {
            $shipment->status()->associate(Status::name('delivered')->first());
            if (!$isReturned)
                $shipment->actual_paid_by_consignee = $request->get('actual_paid');
        } else {
            $newStatus = Status::name($status)->first();
            if (!is_null($newStatus)) {
                $shipment->status()->associate($newStatus);
                if ($newStatus->name == "rescheduled") {
                    $shipment->delivery_date = Carbon::createFromFormat('d/m/Y', $request->get('delivery_date'));
                }
                if (!$isReturned)
                    $shipment->actual_paid_by_consignee = $request->get('actual_paid');
            }
        }
        if ($request->has('branch')) {
            $branch = Branch::find($request->get('branch'));
            $shipment->branch()->associate($branch);
        }
        $status_notes = "";
        if ($request->has("notes")) {
            $notes = $request->get("notes");
            foreach ($notes as $name => $value) {
                $status_notes .= strtoupper(trans("shipment.statuses_options.$name")) . ": " . $value . "\n";
            }
        }
        $status_notes             .= $request->get('external_notes');
        $shipment->status_notes   = $status_notes;
        $shipment->external_notes = $status_notes;
        $shipment->save();
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Shipment $shipment
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(Shipment $shipment)
    {
        $this->authorize('destroy', $shipment);

        try {
            $shipment->delete();
        } catch (\Exception $e) {
            error_log("Cannot delete shipment of id " . $shipment->id);
        }
        return redirect()->route('shipments.index');
    }

    protected function addShipmentDetails(Shipment &$shipment, Request $request)
    {
        if ($request->has('delivery_date')) {
            $newDeliveryDate = Carbon::createFromFormat("d/m/Y", $request->get('delivery_date'));
            if ($newDeliveryDate != $shipment->delivery_date)
                $shipment->delivery_date = $newDeliveryDate;
        }
        if ($request->has('package_weight'))
            $shipment->package_weight = $request->get('package_weight');
        if ($request->has('pieces'))
            $shipment->pieces = $request->get('pieces');
        if ($request->has('shipment_value'))
            $shipment->shipment_value = $request->get('shipment_value');
    }

    protected function addDeliveryDetails(Shipment &$shipment, Request $request)
    {
        if ($request->has('internal_notes'))
            $shipment->internal_notes = $request->get('internal_notes');
        if ($request->has('consignee_name'))
            $shipment->consignee_name = $request->get('consignee_name');
        if ($request->has('phone_number'))
            $shipment->phone_number = $request->get('phone_number');
        if ($request->has('address_maps_link'))
            $shipment->address_maps_link = $request->get('address_maps_link');
        if ($request->has('address_sub_text'))
            $shipment->address_sub_text = $request->get('address_sub_text');
        if ($request->has('service_type'))
            $shipment->service_type = $request->get('service_type');
        if ($request->has('delivery_cost_lodger'))
            $shipment->delivery_cost_lodger = $request->get('delivery_cost_lodger');
        if ($request->has('reference'))
            $shipment->reference = $request->get('reference');
    }

    /**
     * @return \Illuminate\Support\Carbon
     */
    public function suggestedDeliveryDate()
    {
        Carbon::setWeekendDays([
            Carbon::FRIDAY
        ]);
        return now()->nextWeekday();
    }

    public function recalculate(Shipment $shipment)
    {
        $shipment->gatherPriceInformation();
        return back();
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function assignCourier(Request $request)
    {
        if (!auth()->user()->isAdmin()) return abort(403);

        $request->validate([
            'courier'   => 'required|exists:couriers,id',
            'shipments' => 'required|array'
        ]);
        $courier   = Courier::find($request->get('courier'));
        $shipments = $request->get('shipments', []);
        foreach ($shipments as $shipment_id) {
            $shipment = Shipment::find($shipment_id);
            if (is_null($shipment)) continue;
            $shipment->courier()->associate($courier);
            $shipment->push();
        }
        return back();
    }
}
