@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-8 col-visitors">
            <div class="card no-bd bd-3 card-stat">
                <div class="card-body">
                    <h3 class="m-0 font-weight-bold"><i class="icon-graph mr-2"></i>@lang("dashboard.stats.label")</h3>
                    <div class="row">
                        <a href="/shipments.php">
                            <div class="col-md-4 col-sm-6 col-xs-12 widget-info">
                                <div class="left">
                                    <i class="far fa-clock bg-red"></i>
                                </div>
                                <div class="right">
                                    <p class="number countup" data-from="0"
                                       data-to="{{ $statistics['pending'] }}">{{ $statistics['pending'] }}</p>
                                    <p class="text">@lang("dashboard.stats.pending")</p>
                                </div>
                            </div>
                        </a>
                        <a href="/shipments.php?received=show">
                            <div class="col-md-4 col-sm-6 col-xs-12 widget-info">
                                <div class="left">
                                    <i class="fa fa-archive bg-orange"></i>
                                </div>
                                <div class="right">
                                    <p class="number countup" data-from="0"
                                       data-to="{{ $statistics['received'] }}">{{ $statistics['received'] }}</p>
                                    <p class="text">@lang("dashboard.stats.received")</p>
                                </div>
                            </div>
                        </a>
                        <a href="/shipments.php?deliveredtoday=show">
                            <div class="col-md-4 col-sm-6 col-xs-12 widget-info">
                                <div class="left">
                                    <i class="fa fa-check bg-green"></i>
                                </div>
                                <div class="right">
                                    <p class="number countup" data-from="0"
                                       data-to="{{ $statistics['delivered'] }}">{{ $statistics['delivered'] }}</p>
                                    <p class="text">@lang("dashboard.stats.delivered")</p>
                                </div>
                            </div>
                        </a>
                        <a href="/pickups.php?today=get">
                            <div class="col-md-4 col-sm-6 col-xs-12 widget-info">
                                <div class="left">
                                    <i class="fas fa-shopping-bag bg-orange"></i>
                                </div>
                                <div class="right">
                                    <p class="number countup" data-from="0"
                                       data-to="{{ $statistics['pickups'] }}">{{ $statistics['pickups'] }}</p>
                                    <p class="text">@lang("dashboard.stats.pickups")</p>
                                </div>
                            </div>
                        </a>
                        <a href="/clients.php">
                            <div class="col-md-4 col-sm-6 col-xs-12 widget-info">
                                <div class="left">
                                    <i class="fa fa-users bg-green"></i>
                                </div>
                                <div class="right">
                                    <p class="number countup" data-from="0"
                                       data-to="{{ $statistics['clients'] }}">{{ $statistics['clients'] }}</p>
                                    <p class="text">@lang("dashboard.stats.clients")</p>
                                </div>
                            </div>
                        </a>
                        <a href="/couriers.php">
                            <div class="col-md-4 col-sm-6 col-xs-12 widget-info">
                                <div class="left">
                                    <i class="fa fa-truck bg-green"></i>
                                </div>
                                <div class="right">
                                    <p class="number countup" data-from="0"
                                       data-to="{{ $statistics['couriers'] }}">{{ $statistics['couriers'] }}</p>
                                    <p class="text">@lang("dashboard.stats.couriers")</p>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
