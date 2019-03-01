<?php

namespace App\Http\Controllers;

use App\Branch;
use Setting;
use Illuminate\Http\Request;

class SettingsController extends Controller
{

    private $tab;

    public function __construct(Request $request)
    {
        $this->middleware('admin');

        $this->tab = $request->get('tab', "company");

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('settings.index')->with([
            'tab' => $this->tab,
            'branches' => Branch::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        switch ($this->tab) {
            case 'company':
                $this->companySettings($request);
                break;
            case 'accounting':
                $this->accountingSettings($request);
                break;
            case 'branches':
                $this->createBranch($request);
                break;
        }

        return back()->with([
            'alert' => (object)[
                'type' => 'success',
                'msg'  => trans('settings.updated')
            ]
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    private function companySettings(Request $request)
    {
        $companySettingKeys = [
            "company_name",
            "company_address",
            "company_telephone",
            "company_pobox",
            "company_trc",
        ];
        foreach ($companySettingKeys as $companySettingKey) {
            if ($request->has($companySettingKey)) {
                $realName = str_replace("_", ".", $companySettingKey);
                $value = $request->get($companySettingKey);
                Setting::set($realName, $value);
            }
        }
        Setting::save();
    }

    private function accountingSettings(Request $request)
    {
        $companySettingKeys = [
            "accounting_freelanceShare",
            "accounting_promoRequirement",
            "accounting_promoValue",
            "accounting_maxWeight",
            "accounting_loyaltyDays",
        ];
        foreach ($companySettingKeys as $companySettingKey) {
            if ($request->has($companySettingKey)) {
                $realName = str_replace("_", ".", $companySettingKey);
                $value = $request->get($companySettingKey);
                Setting::set($realName, $value);
            }
        }
        Setting::save();
    }

}
