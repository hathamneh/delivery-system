@extends('layouts.pickups')


@section('breadcrumbs')
    {{ Breadcrumbs::render('pickups') }}
@endsection

@section('pageTitle')
    <i class='fa-shopping-bag'></i> @lang("pickup.label")
@endsection

@section('content')
    <div class="scrollable-nav__wrapper">
        <ul class="nav nav-pills scrollable-nav" id="pickupsTabs">
            <li class="nav-item">
                <a class="nav-link active" id="all-tab" href="#" data-toggle="tab" role="tab"
                   aria-selected="true" data-filter="all"><span>@lang('pickup.all')</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="pending-tab" data-toggle="tab" href="#" role="tab" data-filter=".pickup-pending"
                   aria-selected="false"><i class="fa-clock"></i><span>@lang('pickup.pending')</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="declined-tab" data-toggle="tab" href="#" role="tab" data-filter=".pickup-declined"
                   aria-selected="false"><i class="fa-minus-circle"></i><span>@lang('pickup.declined')</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="completed-tab" data-toggle="tab" href="#" role="tab" data-filter=".pickup-completed"
                   aria-selected="false"><i class="fa-check-circle2"></i><span>@lang('pickup.completed')</span></a>
            </li>
        </ul>
    </div>
    <div class="my-3">
        @component('pickups.pickups-list', ['pickups' => $pickups->completed]) @endcomponent
    </div>

@endsection

@section('beforeBody')
    <script src="{{ asset('js/plugins/mixitup.min.js') }}"></script>
    <script>
        var containerEl = document.querySelector('.pickups-list');
        var mixer = mixitup(containerEl);
    </script>
@endsection