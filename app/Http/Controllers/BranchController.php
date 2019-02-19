<?php

namespace App\Http\Controllers;

use App\Branch;
use Illuminate\Http\Request;
use mysql_xdevapi\Exception;

class BranchController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            "name" => 'required',
            "address" => 'required'
        ]);

        Branch::create([
            'name' => $request->get('name'),
            'address' => $request->get('address'),
            'is_main' => $request->get('is_main') === 'on',
        ]);

        return back()->with([
            'alert' => (object)[
                'type' => 'success',
                'msg'  => trans('settings.updated')
            ]
        ]);
    }

    public function update(Request $request, Branch $branch)
    {
        $request->validate([
            "name" => 'required',
            "address" => 'required'
        ]);

        $branch->update([
            'name' => $request->get('name'),
            'address' => $request->get('address'),
            'is_main' => $request->get('is_main') === 'on',
        ]);

        return back()->with([
            'alert' => (object)[
                'type' => 'success',
                'msg'  => trans('settings.updated')
            ]
        ]);
    }

    public function destroy(Request $request, Branch $branch)
    {
        try {
            $branch->delete();
        } catch (\Exception $e) {}

        return back()->with([
            'alert' => (object)[
                'type' => 'success',
                'msg'  => trans('settings.updated')
            ]
        ]);
    }
}
