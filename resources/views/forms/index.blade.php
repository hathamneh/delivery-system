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
        @if(session('alert'))
            @component('bootstrap::alert', [
                'type' => session('alert')->type ?? "primary",
                'dismissible' => true,
                'animate' => true,
               ])
                {!! session('alert')->msg  !!}
            @endcomponent
        @endif
        @if($forms->count())
            <ul class="list-group mb-3">
                @foreach($forms as $form)
                    <li class="list-group-item" data-id="{{ $form->id }}">
                        <div class="d-flex align-items-start">
                            <i class="fa-file mr-2" style="font-size: 1.5rem"></i>
                            <div>
                                <div class="mb-2"><b>{{ $form->name }}</b></div>
                                <small class="text-muted font-weight-bold">Type:</small> <span
                                            class="badge badge-info d-inline-block p-1">{{ $form->attachment->type }}</span>
                                @if(!is_null($form->description))
                                    <div class="form_description mt-3">
                                        <small class="text-muted font-weight-bold">Description:</small> {{ $form->description }}
                                    </div>
                                @endif
                            </div>
                            <div class="attachment__actions ml-auto">
                                @if($form->attachment->type === "pdf")
                                    <a href="{{ $form->attachment->url }}" class="btn btn-dark btn-sm"><i
                                                class="fa-eye mr-1"></i> View</a>
                                @endif
                                <a href="{{ route('attachment.download', [$form->attachment]) }}"
                                   class="btn btn-outline-dark btn-sm"><i
                                            class="fa-download mr-1"></i> Download</a>
                                <a href="{{ route('forms.edit', [$form]) }}" class="btn btn-outline-dark btn-sm"><i
                                            class="fa-edit mr-1"></i> Edit</a>
                                <button type="button" class="btn btn-danger btn-sm delete-attachment"
                                        data-toggle="modal" data-target="#deleteForm-{{ $form->id }}"><i
                                            class="fa-trash"></i> Delete
                                </button>

                            </div>
                        </div>
                    </li>
                @endforeach
            </ul>
            @foreach($forms as $form)
                @component('layouts.components.deleteItem', [
                    'name' => 'form',
                    'id' => $form->id,
                    'action' => route('forms.destroy', [$form]),
                ])@endcomponent
            @endforeach
        @else
            <div class="text-muted mx-auto py-4 text-center">No documents yet!</div>
        @endif
    </div>
@endsection