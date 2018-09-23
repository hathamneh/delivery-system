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
            <div class="col-md-4">
                @include('layouts.partials.weather')
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                @include('layouts.partials.addNew')
            </div>
            <div class="col-md-12 mt-4">
                @include('layouts.partials.goto')
            </div>

        </div>
    </div>
@endsection
