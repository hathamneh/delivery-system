<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MailingController extends Controller
{
    public function index()
    {
        return view('mailing.index');
    }
}
