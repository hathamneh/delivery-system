@extends('layouts.pickups')


@section('breadcrumbs')
    {{ Breadcrumbs::render('pickups') }}
@endsection

@section('pageTitle')
    <i class='fa-shopping-bag'></i> @lang("pickup.label")
@endsection

@section('actionsFirst')
    <div class="header-action">
        <div class="pickups-search">
            <form action="{{ request()->getRequestUri() }}" method="get">
                <input type="text" class="form-control" placeholder="Client Account Number" name="s"
                       data-toggle-tooltip title="Search by Client Account Number" value="{{ $s ?? "" }}">
                <button type="submit" class="search-submit"><i class="fa-search"></i></button>
            </form>
        </div>
    </div>
    <div id="reportrange" class="btn btn-outline-secondary">
        <i class="fa fa-calendar"></i>&nbsp;
        <span></span> <i class="fa fa-caret-down"></i>
    </div>

@endsection

@section('content')
    <div class="container">
        @component('pickups.pickups-list', ['pickups' => $pickups]) @endcomponent
    </div>
@endsection
