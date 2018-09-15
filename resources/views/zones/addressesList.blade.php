<div class="card mt-3">
    <div class="card-body">
        <div class="row">
            <div class="col-sm-12">
                <div class="d-flex mb-1 pb-2">
                    <h3 class="font-weight-bold m-0">@lang('zone.addresses')</h3>
                    <div class="addresses-table-actions ml-auto">
                        @component('layouts.components.modal', [
                            'modalId' => 'bulkEditAddressesModal',
                            'modalTitle' => 'Edit Addresses',
                        ])
                            @include('addresses.form', ['bulk'=>true])
                        @endcomponent
                        <div class="btn-group btn-group-sm">
                            <button class="btn btn-outline-warning selection-action"
                                    data-target="#bulkEditAddressesModal" data-toggle="modal"
                                    disabled><i class="fa-edit"></i> Edit selected
                            </button>
                            <a href="{{ route('address.create', ['zone'=>$zone->id]) }}"
                               data-target="#createAddressModal"
                               data-toggle="modal" class="btn btn-outline-secondary"><i
                                        class="fa fa-plus-circle mr-2"></i> @lang('zone.address.new')
                            </a>
                        </div>
                    </div>
                </div>
                <table class="table table-hover table-selectable addresses-table">
                    <thead>
                    <tr>
                        <th>
                            <div class="custom-control custom-checkbox"
                                 title="@lang('common.selectAll')">
                                <input type="checkbox" class="custom-control-input" id="selectAll">
                                <label class="custom-control-label" for="selectAll"></label>
                            </div>
                        </th>
                        <th>@lang('zone.address.name')</th>
                        <th>@lang('zone.address.sameday_price')</th>
                        <th>@lang('zone.address.scheduled_price')</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    @if($zone->addresses->count())
                        @foreach($zone->addresses as $address)
                            <tr>
                                <td>
                                    <div class="custom-control custom-checkbox"
                                         title="@lang('common.select')">
                                        <input type="checkbox" name="address[]"
                                               value="{{ $address->id }}"
                                               class="custom-control-input"
                                               id="select-{{ $address->id }}">
                                        <label class="custom-control-label"
                                               for="select-{{ $address->id }}"></label>
                                    </div>
                                </td>
                                <td>{{ $address->name }}</td>
                                <td>{{ fnumber($address->sameday_price) }}</td>
                                <td>{{ fnumber($address->scheduled_price) }}</td>
                                <td>
                                    <div class="d-flex">
                                        <a class="btn btn-outline-secondary mr-1 btn-sm"
                                           href="{{ route('address.edit', ['zone' => $zone->id,'address' => $address->id]) }}"
                                           title="@lang('zone.address.edit')"><i class="fa fa-edit"></i></a>
                                        <button class="btn btn-outline-danger btn-sm" data-toggle="modal" data-target="#deleteAddress-{{ $address->id }}"
                                                title="@lang('zone.address.delete')"
                                                type="button"><i class="fa fa-trash"></i></button>
                                        @component('layouts.components.deleteItem', [
                                            'name' => "address",
                                            'id' => $address->id,
                                            'action' => route('address.destroy', ['zone' => $zone->id, 'address' => $address->id])
                                        ]) @endcomponent
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        @php unset($address) @endphp
                    @else
                        <tr class="empty-row">
                            <td colspan="5">
                                <small class="text-center text-muted p-3 d-block">
                                    <i class="fa fa-info-circle"></i> @lang('zone.no_addresses')
                                </small>
                            </td>
                        </tr>
                    @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>