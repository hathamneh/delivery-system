@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-8 col-visitors">
                @if(Auth::user()->isAdmin())
                    @include('layouts.partials.general-stats')
                @endif
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
                        <a href="{{ route('couriers.index') }}" class="quick-link">
                            <div class="row">
                                <div class="icon">
                                    <i class="fa-truck bg-blue"></i>
                                </div>
                                <p class="text">Couriers</p>
                            </div>
                        </a>
                        <a href="{{ route('notes.index') }}" class="quick-link">
                            <div class="row">
                                <div class="icon">
                                    <i class="fa fa-sticky-note bg-pink"></i>
                                </div>
                                <p class="text">Notes</p>
                            </div>
                        </a>
                        <a href="{{ route('pickups.index') }}" class="quick-link">
                            <div class="row">
                                <div class="icon">
                                    <i class="fa-shopping-bag bg-orange"></i>
                                </div>
                                <p class="text">Pickups</p>
                            </div>
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
