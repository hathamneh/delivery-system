<?php

namespace App\Http\Controllers;

use App\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class AccountingController extends Controller
{

    public function __construct()
    {
        View::share([
            "pageTitle" => "Accounting",
            'sidebarCollapsed' => true,
        ]);
    }

    public function index()
    {
        /** @var Client $client */
        $client = Client::find(10000);
        $dueFor = $client->dueFor();
        return view('accounting.index', [
            'dueFor' => $dueFor
        ]);
    }
}
