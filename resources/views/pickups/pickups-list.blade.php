<div class="">
    <ul class="nav nav-pills pickup-pills" id="pickupsTabs">
        <li class="nav-item">
            <a class="nav-link active" id="all-tab" href="#" data-toggle="tab" role="tab" data-mixitup-control
               aria-selected="true" data-filter="all"><span>@lang('pickup.all')</span>
                <span class="badge badge-light ml-2"></span></a>
        </li>
        @foreach($statuses as $status)
            <li class="nav-item">
                <a class="nav-link" id="{{ $status->name }}-tab" data-toggle="tab" href="#" role="tab" data-filter=".pickup-{{ $status->name }}"
                   data-mixitup-control
                   aria-selected="false"><span>@lang("pickup.statuses.{$status->name}")</span>
                    <span class="badge badge-light ml-2"></span></a>
            </li>
        @endforeach
    </ul>
</div>
<div class="my-3">
    <div class="row pickups-list">
        @if($pickups->count())
            @foreach($pickups as $pickup)
                <?php /** @var \App\Pickup $pickup */ ?>
                <div class="col-md-4 col-sm-6 mix pickup-item pickup-{{ $pickup->pickupStatus->name }} {{ auth()->user()->isCourier() ? "layout-2" : "" }}"
                     style="max-height: 200px;min-width: 250px">
                    <div class="card {{ $pickup->statusContext('card') }}">
                        <div class="card-body">
                            @include('pickups.item.actionButtons')

                            @if(auth()->user()->isCourier())
                                @include('pickups.item.layout2')
                            @else
                                @include('pickups.item.layout1')
                            @endif
                        </div>
                        <div class="card-footer">
                            <div class="pickup-status">
                                {!!  $pickup->statusContext('text')  !!}
                            </div>
                            <div class="ml-auto">
                                <a href="#pickupDetails_{{ $pickup->id }}"
                                   class="btn btn-link btn-sm pickup-toggle-details collapsed"
                                   data-toggle="collapse" aria-expanded="false"
                                   aria-controls="pickupDetails_{{ $pickup->id }}"><span>@lang('pickup.show_more')</span>
                                    <i class="fa-angle-down"></i> </a>
                            </div>
                        </div>
                    </div>
                </div>

                @include('pickups.item.actions')

            @endforeach
        @else
            <div class="py-5 w-100 text-center">No Pickups!
                <hr class="mt-5">
            </div>

        @endif
    </div>
</div>

<div class="d-flex justify-content-center">
    {{ $pickups->links() }}
</div>
