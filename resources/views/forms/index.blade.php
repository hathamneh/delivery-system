@extends('layouts.app')

@section('breadcrumbs')
    {{ Breadcrumbs::render('forms') }}
@endsection

@section('pageTitle')
    <i class='fa-file'></i> @lang("forms.label")
@endsection

@section('actions')
    <a href="{{ route('forms.create') }}" class="btn btn-primary"><i
                class="fa-plus-circle"></i> <span>@lang('forms.create')</span>
    </a>
@endsection

@section('content')
    <div class="container">

        <ul class="list-group mb-3">
            @foreach($forms as $form)
                <li class="list-group-item" data-id="{{ $form->id }}">
                    <div class="d-flex align-items-center">
                        <i class="fa-file mr-2" style="font-size: 1.5rem"></i> {{ $form->name }}
                        <div class="attachment__actions ml-auto">

                            <a href="{{ $form->attachment->url }}" class="btn btn-dark btn-sm"><i
                                        class="fa-eye mr-1"></i> View</a>
                            <button type="button" class="btn btn-danger btn-sm delete-attachment"
                                    data-toggle="modal" data-target="#deleteAttachment-{{ $form->attachment->id }}"><i
                                        class="fa-trash"></i> Delete</button>

                        </div>
                    </div>
                    @if(!is_null($form->description))
                        <div class="text-muted form_description mx-2 mt-3">
                            {{ $form->description }}
                        </div>
                    @endif
                </li>
            @endforeach
        </ul>


    </div>
@endsection