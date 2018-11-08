<?php

namespace App\Http\Controllers;

use App\Form;
use Illuminate\Http\Request;

class FormsController extends Controller
{
    public function index()
    {
        $forms = Form::all();
        return view('forms.index')->with([
            'forms' => $forms
        ]);
    }

    public function create()
    {
        return view('forms.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'      => ['required'],
            'form_file' => ['required', 'file', 'max:5000', 'mimes:pdf,doc,docx,xsl,xslx']
        ]);

        $form = new Form;
        $form->name = $request->get('name');
        $form->description = $request->get('description');
        $form->save();
        $form->uploadAttachment($request->file('form_file'));

        return redirect()->route('forms.index');
    }
}
