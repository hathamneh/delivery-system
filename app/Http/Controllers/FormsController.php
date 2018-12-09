<?php

namespace App\Http\Controllers;

use App\Form;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class FormsController extends Controller
{
    public function index()
    {
        $forms = Form::all();
        return view('forms.index')->with([
            'forms'     => $forms,
            'pageTitle' => trans('forms.label')
        ]);
    }

    public function create()
    {
        return view('forms.create')->with([
            'pageTitle' => trans('forms.create')
        ]);
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

        return redirect()->route('forms.index')->with([
            'alert' => [
                'type' => 'success',
                'msg' => trans('forms.saved')
            ]
        ]);
    }

    public function edit(Form $form)
    {
        return view('forms.edit')->with([
            'form'      => $form,
            'pageTitle' => trans('forms.edit') . ": {$form->name}"
        ]);
    }

    public function update(Request $request, Form $form)
    {
        $request->validate([
            'name'      => ['required'],
            'form_file' => ['file', 'max:5000', 'mimes:pdf,doc,docx,xsl,xslx']
        ]);

        $form->name = $request->get('name');
        $form->description = $request->get('description');
        if ($request->hasFile('form_file'))
            $form->replaceAllAttachmentWith($request->file('form_file'));

        $form->save();

        return redirect()->route('forms.index')->with([
            'alert' => [
                'type' => 'success',
                'msg' => trans('forms.saved')
            ]
        ]);
    }

    public function destroy(Form $form)
    {
        try {
            $form->delete();
        } catch (\Exception $ex) {
        }
        return redirect()->route('forms.index')->with([
            'alert' => [
                'type' => 'success',
                'msg' => trans('forms.deleted')
            ]
        ]);
    }

}
