<?php

namespace App\Http\Controllers;

use App\Client;
use App\Courier;
use App\Http\Resources\ReportCollection;
use App\Shipment;
use App\Status;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;

class ReportingController extends Controller
{

    public function __construct()
    {
        $statuses = Status::all();
        View::share([
            'statuses'         => $statuses,
            'sidebarCollapsed' => true,
            'pageTitle'        => trans('reports.label'),
            "pageHeadingClass" => "reporting-heading"
        ]);
    }

    public function index(Request $request)
    {
        $data = [];
        if ($request->has('client'))
            $data['client'] = Client::find((int)$request->get('client'));
        if ($request->has('courier'))
            $data['courier'] = Courier::find((int)$request->get('courier'));
        return view('reports.index', $data);
    }

    /**
     * @param Request $request
     * @return bool|\Illuminate\Http\RedirectResponse
     */
    public function update(Request $request)
    {

        $action = $this->getAction($request);
        if (!$action || !is_string($action)) throw new \BadMethodCallException("No action is provided");

        $shipments_raw = $request->get('shipments', "");
        $shipments = explode(",", $shipments_raw);

        $result = false;
        switch ($action) {
            case "changeStatus":
                $status = $request->get('status');
                $result = $this->bulkChangeStatus($shipments, $status);
                break;
            case "clientPaid":
                $result = $this->bulkClientPaid($shipments);
                break;
            case "courierCashed":
                $result = $this->bulkCourierCashed($shipments);
                break;
        }
        if (!$result) throw new \BadMethodCallException("Action is invalid");
        return back()->with([
            'alert' => (object)[
                'type' => 'success',
                'msg'  => trans_choice('shipment.updated', $result)
            ]
        ]);
    }

    public function bulkChangeStatus(array $shipments, int $status)
    {
        if (!Status::where('id', $status)->exists())
            return false;
        $shipmentsTable = (new Shipment)->getTable();
        return DB::table($shipmentsTable)->whereIn('id', $shipments)->update(array('status_id' => $status));
    }

    /**
     * @param Request $request
     * @return bool|string
     */
    protected function getAction(Request $request)
    {
        if ($request->has('status'))
            return "changeStatus";
        if ($request->has('clientPaid'))
            return "clientPaid";
        if ($request->has('courierCashed'))
            return "courierCashed";
        return false;
    }

    public function bulkClientPaid(array $shipments)
    {
        $shipmentsTable = (new Shipment)->getTable();
        return DB::table($shipmentsTable)->whereIn('id', $shipments)->update(array('client_paid' => true));
    }

    public function bulkCourierCashed(array $shipments)
    {
        $shipmentsTable = (new Shipment)->getTable();
        return DB::table($shipmentsTable)->whereIn('id', $shipments)->update(array('courier_cashed' => true));
    }

    public function makeReport(Request $request)
    {
        $columns = $request->get('columns', false);
        $order = $request->get('order', false);
        $client = $request->get('client', false);
        $search = $request->get('search', false);
        $courier = $request->get('courier', false);
        $length = $request->get("length", 15);
        $from = $request->get('from', false);
        $until = $request->get('until', false);

        $query = Shipment::query();
        if ($client)
            $query = $query->where('client_account_number', $client);
        if ($courier)
            $query = $query->where('courier_id', $courier);

        if (isset($search['value']) && !empty($search['value'])) {
            $query->search($search['value']);
        }

        if($from)
            $query->whereDate("delivery_date", ">=", new Carbon($from), "or");
        if($until)
            $query->whereDate("delivery_date", "<=", new Carbon($from), "or");

        if ($order) {
            $orderOnCollectin = [];
            foreach ($order as $item) {
                if ($item['column'] == 0) continue;
                $colName = $columns[$item['column']]["name"];
                $direction = $item['dir'];
                if ($this->isColName($colName))
                    $query->orderBy($colName, $direction);
                else {
                    $orderOnCollectin[$colName] = $direction;
                }
            }

        }
        $start = $request->get("start", 0);
        $page = floor($start / $length) + 1;
        $paginated = $query->paginate($length, ['*'], null, $page);
        $result = new ReportCollection($paginated);


        if (isset($orderOnCollectin) && count($orderOnCollectin)) {
            foreach ($orderOnCollectin as $name => $direction) {
                if ($direction == "asc")
                    $sorted = $result->sortBy($name);
                elseif ($direction == "desc")
                    $sorted = $result->sortByDesc($name);
            }
            $paginatedAgain = new LengthAwarePaginator($sorted, $paginated->total(), $length, $page);
            $result = new ReportCollection($paginatedAgain);
        }

        return response()->json($result->toArray($request));
    }

    protected function isColName($colName)
    {
        switch ($colName) {
            case "status":
            case "courier":
            case "address":
            case "delivery_cost":
                return false;
        }
        return true;
    }
}
