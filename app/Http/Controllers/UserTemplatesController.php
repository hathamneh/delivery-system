<?php

namespace App\Http\Controllers;

use App\Role;
use App\UserTemplate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class UserTemplatesController extends Controller
{

    public function __construct()
    {
        $this->middleware('admin');

        View::share([
            'pageTitle' => trans('user.roles.label')
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('users.roles.index')->with([
            'templates' => UserTemplate::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('users.roles.create')->with([
            'templates' => UserTemplate::all(),
            'roles'     => Role::all()
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
        /** @var UserTemplate $ut */
        $ut         = UserTemplate::create($request->toArray());
        $manyToMany = [];
        foreach ($request->get('roles', []) as $role => $value) {
            $manyToMany[$role] = ['value' => $value];
        }
        $ut->roles()->sync($manyToMany);
        return redirect()->route('roles.edit', ['role' => $ut->id]);
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
     * @param UserTemplate $role
     * @return \Illuminate\Http\Response
     */
    public function edit(UserTemplate $role)
    {
        $userTemplate = $role;
        $userTemplate->load('roles');
        return view('users.roles.edit')->with([
            'templates' => UserTemplate::all(),
            'ut'        => $userTemplate
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param UserTemplate $role
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, UserTemplate $role)
    {
        //$ut = UserTemplate::findOrFail($id)->first();
        $role->update($request->toArray());
        $manyToMany = [];
        foreach ($request->get('roles', []) as $permission => $value) {
            $manyToMany[$permission] = ['value' => $value];
        }
        $role->roles()->sync($manyToMany);
        return redirect()->route('roles.edit', ['role' => $role]);
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
}
