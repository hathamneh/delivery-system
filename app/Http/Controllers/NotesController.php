<?php

namespace App\Http\Controllers;

use App\Note;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class NotesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $tab = $request->get('tab', 'public');
        $notes = Note::latest();
        if ($tab == 'public')
            $notes->wherePrivate(false);
        elseif ($tab == "private")
            $notes->wherePrivate(true)->where('user_id', Auth::id());
        return view('notes.index', [
            'tab' => $tab,
            'notes' => $notes->simplePaginate(15)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('notes.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        /** @var User $user */
        $user = Auth::user();
        $private = $request->get('private', "off") == "on";
        $user->notes()->create([
            'text' => $request->get('text', null),
            'private' => $private,
        ]);
        return redirect()->route('notes.index', ['tab' => $request->get('tab', "public")]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Note $note
     * @return \Illuminate\Http\Response
     */
    public function show(Note $note)
    {
        $note->read()->attach(auth()->user());
        return back();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Note $note
     * @return \Illuminate\Http\Response
     */
    public function edit(Note $note)
    {
        return view('notes.edit', [
            'note' => $note
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Note $note
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Note $note)
    {
        $note->text = $request->get('text', null);
        $note->private = $request->get('private', "off") == "on";
        $note->save();
        return redirect()->route('notes.index', ['tab' => $request->get('tab', "public")]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Request $request
     * @param  \App\Note $note
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Note $note)
    {
        try {
            $note->delete();
        } catch (\Exception $e) {
        }
        return redirect()->route('notes.index', ['tab' => $request->get('tab', "public")]);
    }
}
