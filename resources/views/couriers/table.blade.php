<div class="table-responsive py-2 px-1 {{ $class ?? "" }}">
    <table class="table table-hover dataTable">
        <thead>
        <tr>
            <th>@lang('courier.id')</th>
            <th>@lang('courier.name')</th>
            <th>@lang('courier.username')</th>
            @if(auth()->user()->isAdmin())
                <th>@lang('courier.password')</th>
            @endif
            <th>@lang('courier.phone')</th>
            <th>@lang('courier.zone')</th>
            <th>@lang('courier.address')</th>
            <th>@lang('common.actions')</th>
        </tr>
        </thead>
        <tbody>
        @foreach($couriers as $courier)
            <?php /** @var \App\Courier $courier */ ?>
            <tr id="client-{{ $courier->id }}" data-id="{{ $courier->id }}">
                <td>{{ $courier->id }}</td>
                <td>[{{ $courier->name }}]</td>
                <td>{{ $courier->user->username }}</td>
                @if(auth()->user()->isAdmin())
                    <td>{{ $courier->password }}</td>
                @endif
                <td>{{ $courier->phone_number }}</td>
                <td>{{ $courier->zones->count() ? $courier->zones->pluck('name')->implode(',') : '' }}</td>
                <td>{{ $courier->address}}</td>
                <td>
                    <div class="btn-group">
                        <a href="{{ route('couriers.show', ['courier'=>$courier->id]) }}"
                           data-toggle="tooltip"
                           class="btn btn-light btn-sm" title="@lang('courier.statistics')">
                            <i class="fa-tachometer-alt"></i></a>
                        <a href="{{ route('reports.index', ['courier'=>$courier->id]) }}"
                           data-toggle="tooltip"
                           class="btn btn-light btn-sm" title="@lang('reports.label')">
                            <i class="fa-reports"></i></a>
                        <a href="{{ route('couriers.edit', ['courier'=>$courier->id]) }}"
                           data-toggle="tooltip"
                           class="btn btn-light btn-sm" title="@lang('courier.edit')">
                            <i class="fa fa-edit"></i></a>
                        <button class="btn btn-light btn-sm" type="button" data-toggle-tooltip
                                title="@lang('courier.delete')"
                                data-toggle="modal" data-target="#deleteCourier-{{ $courier->id }}">
                            <i class="fa fa-trash"></i>
                        </button>
                    </div>
                    @component('layouts.components.deleteItem', [
                        'name' => 'courier',
                        'id' => $pickup->id,
                        'action' => route('couriers.destroy', [$courier])
                    ])@endcomponent
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
