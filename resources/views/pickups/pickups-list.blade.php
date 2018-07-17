<div class="row pickups-list">
    @foreach($pickups as $pickup)
        <?php /** @var \App\Pickup $pickup */ ?>
        <div class="col-md-4 col-sm-6 mix pickup-item pickup-{{ $pickup->status }}">
            <div class="card {{ $pickup->statusContext('card') }}">
                <div class="card-body">
                    <div class="pickup-actions">
                        <a href="{{ route('pickups.edit', ['pickup'=> $pickup->id]) }}" title="@lang('pickup.edit')"
                           data-toggle="tooltip"
                           class="btn btn-light btn-sm"><i class="fa-pencil-alt"></i></a>
                        <a href="{{ route('pickups.edit', ['pickup'=> $pickup->id]) }}" title="@lang('pickup.history')"
                           data-toggle="tooltip"
                           class="btn btn-light btn-sm"><i class="fa-history"></i></a>
                        <form class="delete-form"
                              action="{{ route('pickups.destroy', ['pickup' => $pickup->id]) }}"
                              method="post">
                            {{ csrf_field() }}
                            {{ method_field('DELETE') }}
                        </form>
                        <span title="@lang('pickup.delete')" data-toggle="tooltip" class="d-inline-block">
                                <button class="btn btn-light text-danger btn-sm" type="button" data-toggle="modal"
                                         data-target="#deletePickup-{{ $pickup->id }}"><i class="fa fa-trash"></i></button>
                            </span>
                    </div>

                    <h3>
                        <a href="{{ route('clients.show', ['client' => $pickup->client->account_number]) }}">{{ $pickup->client->name }}</a>
                    </h3>
                    <small>
                        <span title="{{{ trans("pickup.expected_packages_number"). ": ". $pickup->expected_packages_number }}}"
                              data-toggle="tooltip">
                            @lang('pickup.expected'): <b class="px-2">{{ $pickup->expected_packages_number }}</b>
                        </span> |&nbsp;
                        <span title="{{{  $pickup->actual_packages_number ? trans("pickup.actual_packages_number").": ".$pickup->actual_packages_number : trans('pickup.not_picked_up_yet') }}}"
                              data-toggle="tooltip">
                            @lang('pickup.actual'): <b class="px-2">{{ $pickup->actual_packages_number ?? "?" }}</b>
                        </span>

                    </small>
                    <br>
                    <small class="text-muted">
                        @lang('courier.single'): <b><a
                                    href="{{ route('couriers.show', ['courier'=>$pickup->courier->id]) }}">{{ $pickup->courier->name }}</a></b>
                        |
                        @lang('pickup.identifier'): <b>{{ $pickup->identifier }}</b>
                    </small>

                    <div class="pickup-meta collapse" id="pickupDetails_{{ $pickup->id }}">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">
                                <span class="meta-label">
                                    <i class="fa-shopping-bag"></i> @lang('pickup.pickup_from'):
                                </span>
                                <span class="meta-value">
                                    @lang('pickup.from_'.$pickup->pickup_from)
                                </span>
                            </li>
                            <li class="list-group-item">
                                <span class="meta-label">
                                    <i class="fa-clock2"></i> @lang('pickup.available_time'):
                                </span>
                                <div class="meta-value">
                                    <div><span class="text-muted mr-2">From:</span> {{ $pickup->available_date_start }} <kbd>{{ $pickup->available_time_start }}</kbd>
                                    </div>
                                    <div><span class="text-muted mr-2">To:</span> {{ $pickup->available_date_end }} <kbd>{{ $pickup->available_time_end }}</kbd>
                                    </div>
                                </div>
                            </li>
                            <li class="list-group-item">
                                <span class="meta-label">
                                    <i class="fa-truck"></i> @lang('courier.phone'):
                                </span>
                                <span class="meta-value">
                                    {{ $pickup->courier->phone_number }}
                                </span>
                            </li>
                            <li class="list-group-item">
                                <span class="meta-label">
                                    <i class="fa-user-circle2"></i> @lang('pickup.'.$pickup->pickup_from.'_phone'):
                                </span>
                                <span class="meta-value">
                                    {{ $pickup->phone_number }}
                                </span>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="pickup-status">
                        {!!  $pickup->statusContext('text')  !!}
                    </div>
                    <div class="ml-auto">
                        <a href="#pickupDetails_{{ $pickup->id }}" class="btn btn-link btn-sm pickup-toggle-details collapsed"
                           data-toggle="collapse" aria-expanded="false" aria-controls="pickupDetails_{{ $pickup->id }}"><span>@lang('pickup.show_more')</span>
                            <i class="fa-angle-down"></i> </a>
                    </div>
                </div>
            </div>
        </div>
            @component('bootstrap::modal',[
                                'id' => 'deletePickup-'.$pickup->id
                            ])
                @slot('title')
                    Delete this pickup?
                @endslot
                This is irreversible, all his information will be deleted permanently!
                @slot('footer')
                    <button class="btn btn-outline-secondary"
                            data-dismiss="modal">@lang('common.cancel')</button>
                    <button class="btn btn-danger ml-auto" type="button"
                            data-delete="{{ $pickup->id }}"><i
                                class="fa fa-trash"></i> @lang('pickup.delete')
                    </button>
                @endslot
            @endcomponent
    @endforeach
</div>