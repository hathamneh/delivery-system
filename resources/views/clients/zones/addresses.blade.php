<div class="custom-addresses-actions">
    <div class="btn-group btn-group-sm mb-3">
        <button class="btn btn-outline-info selection-action selection-action-customize" disabled data-toggle="modal"
                data-target="#bulkCustomizeModal">
            <i class="fa-edit align-middle"></i> Customize Selected
        </button>
        <button class="btn btn-outline-danger selection-action selection-action-delete" disabled data-toggle="modal"
                data-target="#bulkDeleteAddressModal">
            <i class="fa-history align-middle"></i> Reset/Delete Selected
        </button>
        <button class="btn btn-outline-success" data-toggle="modal" data-target="#addCustomAddressModal">
            <i class="fa-plus align-middle"></i> Add Address
        </button>
    </div>
    @include('clients.componenets.bulkCustomizeModal')
    @include('clients.componenets.bulkDeleteModal')
    @include('clients.componenets.addCustomAddressModal')
</div>
<table class="table table-hover table-selectable customAddresses-table">
    <thead>
    <tr>
        <th style="padding-left: 0.5rem;">
            <div class="custom-control custom-checkbox" title="@lang('common.selectAll')">
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
    @php $i = 1; @endphp
    @foreach($selected->addresses as $address)
        @php /** @var \App\Address|\App\CustomAddress $address **/
        $custom = !!($address instanceof \App\CustomAddress);
        $route = $custom ? 'clients.addresses.update' : 'clients.addresses.store';
        @endphp
        <tr class="{{ $custom == true ? $address->html_class : "" }}">
            <td>
                <div class="custom-control custom-checkbox" title="@lang('common.select')">
                    <input type="checkbox" name="{{ ($custom == true ? 'customAddress[]' : 'address[]') }}"
                           value="{{ $address->id }}" class="custom-control-input"
                           id="select-{{ ($custom == true ? "custom-" : "") . $address->id }}">
                    <label class="custom-control-label"
                           for="select-{{ ($custom == true ? "custom-" : "") . $address->id }}"></label>
                </div>
            </td>
            <td>{{ $address->name }}</td>
            <td>{{ fnumber($address->sameday_price) }}</td>
            <td>{{ fnumber($address->scheduled_price) }}</td>
            <td>
                <div class="btn-group">
                    <button class="btn btn-sm btn-outline-secondary" data-toggle="modal"
                            data-target="#{{ ($custom == true ? 'editCustomAddress-' : 'customizeAddress-') . $address->id }}">
                        <i class="fa-edit mr-2"></i> Customize
                    </button>
                    @if($custom == true)
                        @if($address->isNew())
                            <button class="btn btn-outline-danger btn-sm" title="Delete"
                                    onclick="$('#deleteClientAddress-{{ $address->id }}').submit()"><i
                                        class="fa-trash"></i>
                            </button>
                        @else
                            <button class="btn btn-outline-dark btn-sm" title="Reset"
                                    onclick="$('#deleteClientAddress-{{ $address->id }}').submit()"><i
                                        class="fa-history"></i>
                            </button>
                        @endif
                    @endif
                </div>
                @if($custom==true)
                    <form id="deleteClientAddress-{{ $address->id }}"
                          action="{{ route('clients.addresses.destroy', ['client' => $client, 'address' => $address]) }}"
                          method="post">
                        {{ csrf_field() }}
                        {{ method_field('delete') }}
                    </form>
                @endif
                @include('clients.componenets.customizeAddressModal')
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
