<div class="table-responsive py-2 px-1 open-account-couriers">
    <table class="table table-hover">
        <thead>
        <tr>
            <th>@lang('courier.id')</th>
            <th>@lang('courier.name')</th>
            <th>@lang('courier.username')</th>
            <th>@lang('courier.password')</th>
            <th>@lang('courier.phone')</th>
            <th>@lang('courier.zone')</th>
            <th>@lang('courier.address')</th>
        </tr>
        </thead>
        <tbody>
        @foreach($haveWorkTodayCouriers as $courier)
            <?php /** @var \App\Courier $courier */ ?>
            <tr id="client-{{ $courier->id }}" class="{{ $courier->isOpenAccount() ? "open" : "closed" }}"
                data-id="{{ $courier->id }}" data-href="{{ route('couriers.inventory', [$courier]) }}">
                <td>{{ $courier->id }}</td>
                <td>[{{ $courier->name }}]</td>
                <td>{{ $courier->user->username }}</td>
                <td>{{ $courier->password }}</td>
                <td>{{ $courier->phone_number }}</td>
                <td>{{ $courier->zones->count() ? $courier->zones->pluck('name')->implode(',') : '' }}</td>
                <td>{{ $courier->address}}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
    <div class="mt-3 d-flex">
        <div class="table-key">
            <div class="box open"></div>
            <small class="font-weight-bold">Open Account</small>
        </div>
        <div class="table-key">
            <div class="box closed bg-white"></div>
            <small class="font-weight-bold">Closed Account</small>
        </div>
    </div>
</div>
