<?php

namespace App\Http\Controllers;

use App\Address;
use App\Courier;
use App\GuestShipment;
use App\Http\Requests\StoreShipmentRequest;
use App\ReturnedShipment;
use App\Shipment;
use App\Status;
use App\SubStatus;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class ShipmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $type = $request->get('type', 'normal,guest');
        $types = explode(",",$type);
        $shipments = Shipment::type($types)->filtered();
        return view('shipments.index', [
            'shipments' => $shipments,
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function returned()
    {
        $shipments = ReturnedShipment::all();
        return view('shipments.index', [
            'shipments' => $shipments,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param string $type
     * @return \Illuminate\Http\Response
     */
    public function create($type = "wizard")
    {
        $suggestedWaybill = (new Shipment)->generateNextWaybill();
        $statuses = Status::whereIn('name', ['picked_up', 'received'])->get();
        $couriers = Courier::all();
        $addresses = Address::all();
        $data = [
            'statuses'         => $statuses,
            'suggestedWaybill' => $suggestedWaybill,
            'couriers'         => $couriers,
            'addresses'        => $addresses,
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

        $clientData = $request->get('shipment_client');

        $shipment = null;
        if ($clientData['type'] == 'client')
            $shipment = new Shipment;
        elseif ($clientData['type'] == 'guest')
            $shipment = new GuestShipment;

        // make relations
        $shipment->saveClient($clientData);
        $shipment->address()->associate(Address::findOrFail($request->get('address_from_zones')));
        $shipment->courier()->associate(Courier::findOrFail($request->get('courier')));
        $shipment->status()->associate(Status::findOrFail($request->get('status')));
        // save form data
        $shipment->waybill = $request->get('waybill');
        $this->addShipmentDetails($shipment, $request);
        $this->addDeliveryDetails($shipment, $request);
        // Money calculations
        $shipment->gatherPriceInformation();
        $shipment->push();
        // TODO: Attach Extra Services

        return redirect()->route('shipments.show', ['shipment' => $shipment]);
    }

    /**
     * Display the specified resource.
     *
     * @param Shipment $shipment
     * @param string $tab
     * @return \Illuminate\Http\Response
     */
    public function show(Shipment $shipment, $tab = "status")
    {
        $shipment = $shipment->type == "guest" ? GuestShipment::find($shipment->id) : $shipment;
        $data = [
            'shipment' => $shipment->load('status'),
            'tab'      => $tab,
        ];
        if ($tab == "actions") {
            $data['statuses'] = Status::all();
            $data['returned_statuses'] = Status::whereIn('name', ['rejected', 'cancelled'])->get();
            $data['subStatuses'] = $shipment->status->subStatuses()->get();
        }
        return view('shipments.show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Shipment $shipment
     * @return \Illuminate\Http\Response
     */
    public function edit(Shipment $shipment)
    {
        $statuses = Status::whereIn('name', ['picked_up', 'received'])->get();
        $couriers = Courier::all();
        $addresses = Address::all();
        return view('shipments.show', [
            'shipment'  => $shipment,
            'tab'       => 'edit',
            'statuses'  => $statuses,
            'couriers'  => $couriers,
            'addresses' => $addresses,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param Shipment $shipment
     * @param string $tab
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Shipment $shipment)
    {
        $tab = $request->get('tab');
        switch ($tab) {
            case "details":
                $this->addShipmentDetails($shipment, $request);
                $shipment->save();
                return redirect()->route("shipments.edit", ['shipment' => $shipment]);
                break;
            case "delivery":
                $this->addDeliveryDetails($shipment, $request);
                if ($request->get('address_from_zones') != $shipment->address_id)
                    $shipment->address()->associate(Address::findOrFail($request->get('address_from_zones')));
                if ($request->get('courier') != $shipment->courier_id)
                    $shipment->courier()->associate(Courier::findOrFail($request->get('courier')));
                $shipment->save();
                return redirect()->route("shipments.edit", ['shipment' => $shipment]);
                break;
            case "status":
                $status = Status::findOrFail($request->get('status'));
                $subStatus = SubStatus::find($request->get('sub_status'));
                $shipment->status()->associate($status);
                if ($subStatus)
                    $shipment->subStatus()->associate($subStatus);
                $shipment->status_notes = $request->get('status_notes');
                $shipment->save();
                return redirect()->route("shipments.show", ['shipment' => $shipment, 'tab' => 'actions']);
                break;
            default:
                throw new BadRequestHttpException("Shipment update tab is not set");
        }

    }

    public function makeReturn(Request $request, Shipment $shipment)
    {
        $status = Status::findOrFail($request->get('original_status'));
        $shipment->status()->associate($status);
        $shipment->update([
            'status_notes' => $request->get('status_notes'),
        ]);
        $new = ReturnedShipment::createFrom($shipment, [
            'delivery_date' => Carbon::createFromFormat("d-m-Y h:i A", $request->get('delivery_date') . " 12:00 AM")
        ]);

        return redirect()->route('shipments.show', ['shipment'=>$new]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Shipment $shipment)
    {
        try {
            $shipment->delete();
        } catch (\Exception $e) {
            error_log("Cannot delete shipment of id ". $shipment->id);
        }
        return redirect()->route('shipments.index');
    }

    protected function addShipmentDetails(Shipment &$shipment, Request $request)
    {
        $newDeliveryDate = Carbon::createFromFormat("d-m-Y h:i A", $request->get('delivery_date') . " 12:00 AM");
        if ($newDeliveryDate != $shipment->delivery_date)
            $shipment->delivery_date = $newDeliveryDate;
        $shipment->package_weight = $request->get('package_weight');
        $shipment->shipment_value = $request->get('shipment_value');

        // services stuff
    }

    protected function addDeliveryDetails(Shipment &$shipment, Request $request)
    {
        $shipment->internal_notes = $request->get('internal_notes');
        $shipment->consignee_name = $request->get('consignee_name');
        $shipment->phone_number = $request->get('phone_number');
        $shipment->address_maps_link = $request->get('address_maps_link');
        $shipment->address_sub_text = $request->get('address_sub_text');
        $shipment->service_type = $request->get('service_type');
        $shipment->delivery_cost_lodger = $request->get('delivery_cost_lodger');
    }
}
