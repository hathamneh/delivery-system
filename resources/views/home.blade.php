@extends('layouts.app')


@section('smallTitle')
    <b class="px-3 py-2">{{ $title ?? "" }}</b>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-8 col-visitors">
                @isset($statistics)
                    @include('layouts.partials.general-stats')
                @endisset
            </div>
            @if(!auth()->user()->isCourier())
                <div class="col-md-4">
                    @include('layouts.partials.weather')
                </div>
            @endif
        </div>
        <div class="row">
            @if(!auth()->user()->isCourier())
                <div class="col-md-12">
                    @include('layouts.partials.addNew')
                </div>
            @endif
            <div class="col-md-12 mt-4">
                @include('layouts.partials.goto')
            </div>

        </div>
    </div>
@endsection
