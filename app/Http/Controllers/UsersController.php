<?php

namespace App\Http\Controllers;

use App\User;
use App\UserTemplate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use PhpParser\Node\Stmt\Return_;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $users = User::with('template');
        if ($request->has('template')) {
            $users->where('user_template_id', $request->get('template'));
        }
        $templates = UserTemplate::all();
        return view('users.index')->with([
            'users'     => $users->get(),
            'templates' => $templates
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $templates = UserTemplate::all();
        return view('users.create')->with([
            'templates' => $templates
        ]);
    }

    /**
     * Store a newly created resource in storage.$data
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validData = $request->validate([
            'username' => 'required|string|max:255|unique:users',
            'template' => 'required|int|exists:user_templates,id',
            'email'    => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);
        /** @var User $user */
        $user = new User;
        $user->username = $request->get('username');
        $user->email = $request->get('email');
        $user->password = Hash::make($request->get('password'));
        $user->template()->associate($request->get('template'));
        $user->save();

        return redirect()->route('users.index');
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
     * @param User $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        $user->load('template');
        $templates = UserTemplate::all();
        return view('users.edit')->with([
            'user'      => $user,
            'templates' => $templates,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param User $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {

        //dd($request->toArray());
        $request->validate([
            'username' => 'required|string|max:255|unique:users,username,' . $user->id,
            'template' => 'required|int|exists:user_templates,id',
            'email'    => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:6|confirmed',
        ]);

        $user->load('template');

        if ($request->get('username') != $user->username)
            $user->username = $request->get('username');
        if ($request->get('email') != $user->email)
            $user->email = $request->get('email');
        if (is_null($user->template) || $request->get('template') != $user->template->id)
            $user->template()->associate($request->get('template'));
        if ($request->has('password'))
            $user->password = Hash::make($request->get('password'));
        $user->save();
        return back()->with([
            'alert' => (object)[
                'type' => 'success',
                'msg'  => trans('user.updated')
            ]
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        try {
            $user->delete();
            return redirect()->route('users.index');
        } catch (\Exception $e) {
            abort('400', 'Deleting user failed');
        }
    }
}
