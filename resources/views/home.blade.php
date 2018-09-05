@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-8 col-visitors">
                <h3 class="m-0 mb-4 font-weight-bold"><i class="icon-graph mr-2"></i>@lang("dashboard.stats.label")</h3>
                <div class="widget-infobox">
                    <div class="infobox">
                        <div class="left">
                            <i class="fa fa-clock bg-blue"></i>
                        </div>
                        <div class="right">
                            <div>
                                <span class=" pull-left">{{ $statistics['pending'] }}</span>
                            </div>
                            <div class="txt">Pending</div>
                        </div>
                    </div>
                    <div class="infobox">
                        <div class="left">
                            <i class="fa fa-archive bg-red"></i>
                        </div>
                        <div class="right">
                            <div class="clearfix">
                                <div>
                                    <span class="c-red pull-left">{{ $statistics['received'] }}</span>
                                </div>
                                <div class="txt">Received</div>
                            </div>
                        </div>
                    </div>
                    <div class="infobox">
                        <div class="left">
                            <i class="fa fa-check bg-green"></i>
                        </div>
                        <div class="right">
                            <div class="clearfix">
                                <div>
                                    <span class="c-green pull-left">{{ $statistics['delivered'] }}</span>
                                </div>
                                <div class="txt">Delivered</div>
                            </div>
                        </div>
                    </div>
                    <div class="infobox">
                        <div class="left">
                            <i class="fa-reply bg-purple"></i>
                        </div>
                        <div class="right">
                            <div class="clearfix">
                                <div>
                                    <span class=" pull-left">{{ $statistics['returned'] }}</span>
                                </div>
                                <div class="txt">Returned</div>
                            </div>
                        </div>
                    </div>
                    <div class="infobox">
                        <div class="left">
                            <i class="fa-shopping-bag bg-orange"></i>
                        </div>
                        <div class="right">
                            <div class="clearfix">
                                <div>
                                    <span class="c-red pull-left">{{ $statistics['pickups'] }}</span>
                                </div>
                                <div class="txt">Pickups</div>
                            </div>
                        </div>
                    </div>
                    <div class="infobox">
                        <div class="left">
                            <i class="fa-user-tie bg-purple"></i>
                        </div>
                        <div class="right">
                            <div class="clearfix">
                                <div>
                                    <span class="c-green pull-left">{{ $statistics['clients'] }}</span>
                                </div>
                                <div class="txt">Clients</div>
                            </div>
                        </div>
                    </div>
                    <div class="infobox">
                        <div class="left">
                            <i class="fa-truck bg-blue"></i>
                        </div>
                        <div class="right">
                            <div class="clearfix">
                                <div>
                                    <span class="c-green pull-left">{{ $statistics['couriers'] }}</span>
                                </div>
                                <div class="txt">Couriers</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div id="container">

                    <!-- Code generated at https://WeatherWidget.io -->
                    <a class="weatherwidget-io" href="https://forecast7.com/en/31d9535d93/amman/" data-label_1="Amman"
                       data-label_2="Wehather" data-theme="blue">Amman Weather</a>
                    <script>
                        !function (d, s, id) {
                            var js, fjs = d.getElementsByTagName(s)[0];
                            if (!d.getElementById(id)) {
                                js = d.createElement(s);
                                js.id = id;
                                js.src = "https://weatherwidget.io/js/widget.min.js";
                                fjs.parentNode.insertBefore(js, fjs);
                            }
                        }(document, "script", "weatherwidget-io-js");
                    </script>
                    <!-- / Code generated at https://WeatherWidget.io -->

                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card mt-4">
                    <div class="card-body">
                        <div class="d-inline-block mr-3">
                            <i class="fa-plus mr-2"></i><b>Add New</b>
                        </div>

                        <div class="btn-group btn-group-lg">
                            <a href="{{ route('shipments.create') }}" class="btn btn-info"><i
                                        class="fa-shipment"></i> Shipment</a>
                            <a href="{{ route('pickups.create') }}" class="btn btn-outline-primary"><i
                                        class="fa-shopping-bag"></i> Pickup</a>
                            <a href="{{ route('notes.create') }}" class="btn btn-outline-secondary"><i class="fa-sticky-note"></i>
                                Note</a>
                            <a href="{{ route('couriers.create') }}" class="btn btn-outline-secondary"><i class="fa-truck"></i>
                                Courier</a>
                            <a href="{{ route('clients.create') }}" class="btn btn-outline-secondary"><i
                                        class="fa-user-tie"></i> Client</a>
                            <a href="{{ route('zones.create') }}" class="btn btn-outline-secondary"><i
                                        class="fa-map-marker-alt"></i> Zone</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12 mt-4">
                <div class="card">
                    <div class="card-header">
                        <i class="fa-arrow-circle-right mr-2"></i><b>Go To</b>
                    </div>
                    <div class="card-body">
                        <a href="{{ route('shipments.index') }}" class="quick-link">
                            <div class="row">
                                <div class="icon">
                                    <i class="fa-shipment bg-blue"></i>
                                </div>
                                <p class="text">Shipments</p>
                            </div>
                        </a>
                        <a href="{{ route('clients.index') }}" class="quick-link">
                            <div class="row">
                                <div class="icon">
                                    <i class="fa-user-tie bg-purple"></i>
                                </div>
                                <p class="text">Clients</p>
                            </div>
                        </a>
                        <div class="quick-link">
                            <div class="row">
                                <div class="icon">
                                    <i class="fa-truck bg-blue"></i>
                                </div>
                                <p class="text">Couriers</p>
                            </div>
                        </div>
                        <div class="quick-link">
                            <div class="row">
                                <div class="icon">
                                    <i class="fa fa-sticky-note bg-pink"></i>
                                </div>
                                <p class="text">Notes</p>
                            </div>
                        </div>
                        <div class="quick-link">
                            <div class="row">
                                <div class="icon">
                                    <i class="fa-shopping-bag bg-orange"></i>
                                </div>
                                <p class="text">Pickups</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
