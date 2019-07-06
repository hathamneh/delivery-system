<div class="row">
    @if($zones->count())
        @foreach($zones as $zone)
            <div class="col-md-12 zone-column border-secondary">
                <div class="row">
                    <div class="col-md-4">
                        <div class="zone-card mb-md-0 mb-1">
                            <h4 class="font-weight-bold text-center">{{ $zone->name }}</h4>
                            <div class="zone-info">
                                <div>
                                    <b>{{ $zone->base_weight }}</b>
                                    <small>@lang('zone.standard_weight')</small>
                                </div>
                                <div>
                                    <b>{{ $zone->charge_per_unit }}</b>
                                    <small>@lang('zone.charge_per_unit')</small>
                                </div>
                                <div>
                                    <b>{{ $zone->extra_fees_per_unit }}</b>
                                    <small>@lang('zone.extra_fees_per_unit')</small>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="col-md-6">
                        @if($zone->addresses->count())
                            <div class="card zone-addresses-list"
                                 aria-expanded="false" aria-controls="zoneAddresses_{{ $zone->id }}">
                                <ul class="list-group list-group-flush"
                                    id="zoneAddresses_{{ $zone->id }}">
                                    @foreach($zone->addresses as $address)
                                        <li class="list-group-item address-group-item">
                                            <div>{{ $address->name }}</div>
                                            <div class="actions">
                                                <a class="btn btn-link btn-sm"
                                                   href="{{ route('address.edit', ['zone' => $zone->id,'address' => $address->id]) }}"
                                                   title="@lang('zone.address.edit')"><i class="fa fa-edit"></i></a>
                                                <button class="btn btn-link btn-sm"
                                                        title="@lang('zone.address.delete')"
                                                        type="button" data-toggle="modal" data-target="#deleteAddress-{{ $address->id }}">
                                                    <i class="fa fa-trash"></i></button>
                                            </div>
                                        </li>
                                        @component('layouts.components.deleteItem', [
                                            'name' => "address",
                                            'id' => $address->id,
                                            'action' => route('address.destroy', ['zone' => $zone->id, 'address' => $address->id])
                                        ]) @endcomponent
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                    </div>
                    <div class="col-md-2 ml-auto">
                        <div class="d-flex flex-md-column justify-content-center align-items-center py-2 h-100 mt-1">
                            <a href="{{ route('zones.edit', ['zone'=>$zone->id]) }}"
                               class="btn btn-outline-secondary mb-md-1 mr-md-0 mr-1" title="@lang('zone.edit')">
                                <i class="fa fa-edit"></i> @lang('zone.edit')</a>
                            <button class="btn btn-outline-secondary" title="@lang('zone.delete')"
                                    type="button" data-toggle="modal" data-target="#deleteZone-{{ $zone->id }}"><i
                                        class="fa fa-trash"></i> @lang('zone.delete')
                            </button>
                        </div>
                        @component('layouts.components.deleteItem', [
                            'name' => "zone",
                            'id' => $zone->id,
                            'action' => route('zones.destroy', ['zone' => $zone->id])
                        ]) @endcomponent
                        <form action="{{ route('zones.destroy', ['zone' => $zone->id]) }}"
                              method="post" id="deleteZone-{{ $zone->id }}">
                            {{ csrf_field() }}
                            {{ method_field('DELETE') }}

                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    @endif
</div>