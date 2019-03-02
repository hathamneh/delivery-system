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
                <div class="input-group">
                    <div class="input-group-prepend btn-group-toggle" data-toggle="buttons">
                        <label class="btn btn-outline-secondary active"
                               title="@lang('client.label')" data-toggle="tooltip">
                            <input type="radio" name="searchType"
                            id="searchType_client" autocomplete="off" value="client" required checked>
                            <i class="fa-user-tie"></i>
                        </label>
                        <label class="btn btn-outline-secondary"
                               title="@lang('courier.label')" data-toggle="tooltip">
                            <input type="radio" name="searchType"
                            id="searchType_courier" autocomplete="off" value="courier" required>
                            <i class="fa-truck"></i>
                        </label>
                    </div>
                <input type="text" class="form-control" placeholder="Search" name="s"
                       data-toggle-tooltip title="Search pickups" value="{{ $s ?? "" }}">
                <button type="submit" class="search-submit"><i class="fa-search"></i></button>
                </div>
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
        @foreach ($errors->all() as $message)
            @component('bootstrap::alert', [
                'type' => "danger",
                'dismissible' => true,
                'animate' => true,
               ])
                {!! $message  !!}
            @endcomponent
        @endforeach
        @component('pickups.pickups-list', ['pickups' => $pickups, 'statuses' => $statuses, 'statusesOptions' => $statusesOptions]) @endcomponent
    </div>
@endsection
