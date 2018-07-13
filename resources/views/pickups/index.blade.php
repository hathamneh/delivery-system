@extends('layouts.pickups')


@section('breadcrumbs')
    {{ Breadcrumbs::render('pickups') }}
@endsection

@section('pageTitle')
    <i class='fa-shopping-bag'></i> @lang("pickup.label")
@endsection

@section('content')
    <div class="scrollable-nav__wrapper">
        <ul class="nav nav-tabs scrollable-nav" id="pickupsTabs" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="pending-tab" data-toggle="tab" href="#pending" role="tab"
                   aria-controls="pending"
                   aria-selected="true"><i class="fa-clock"></i><span>@lang('pickup.pending')</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="declined-tab" data-toggle="tab" href="#declined" role="tab"
                   aria-controls="declined"
                   aria-selected="false"><i class="fa-minus-circle"></i><span>@lang('pickup.declined')</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="completed-tab" data-toggle="tab" href="#completed" role="tab"
                   aria-controls="completed"
                   aria-selected="false"><i class="fa-check-circle2"></i><span>@lang('pickup.completed')</span></a>
            </li>
        </ul>
    </div>
    <div class="tab-content my-3">
        <div class="tab-pane active" id="pending" role="tabpanel" aria-labelledby="pending-tab">
            <p>This is the pending pickups:</p>
            @component('pickups.pickups-list', ['pickups' => $pickups->pending]) @endcomponent
        </div>
        <div class="tab-pane" id="declined" role="tabpanel" aria-labelledby="declined-tab">
            <p>This is the declined pickups:</p>
            @component('pickups.pickups-list', ['pickups' => $pickups->declined]) @endcomponent
        </div>
        <div class="tab-pane" id="completed" role="tabpanel" aria-labelledby="completed-tab">
            <p>This is the completed pickups:</p>
            @component('pickups.pickups-list', ['pickups' => $pickups->completed]) @endcomponent
        </div>
    </div>

@endsection