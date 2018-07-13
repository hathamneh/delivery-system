@extends('layouts.couriers')


@section('breadcrumbs')
    {{ Breadcrumbs::render('couriers') }}
@endsection

@section('pageTitle')
    <i class='fa-user-tie'></i> @lang("couriers.label")
@endsection

@section('content')
    @if(session('alert'))
        <div class="">
            @component('bootstrap::alert', [
                'type' => session('alert')->type ?? "primary",
                'dismissible' => true,
                'animate' => true,
               ])
                {{ session('alert')->msg }}
            @endcomponent
        </div>
    @endif
    <div class="table-responsive py-2 px-1">
        <table class="table dataTable">
            <thead>
            <tr>
                <th>@lang('courier.id')</th>
                <th>@lang('courier.name')</th>
                <th>@lang('courier.username')</th>
                <th>@lang('courier.password')</th>
                <th>@lang('courier.phone')</th>
                <th>@lang('courier.zone')</th>
                <th>@lang('courier.address')</th>
                <th>@lang('common.actions')</th>
            </tr>
            </thead>
            <tbody>
            @foreach($couriers as $courier)
                <?php /** @var \App\Client $client */ ?>
                <tr id="client-{{ $courier->id }}" data-id="{{ $courier->id }}">
                    <td>{{ $courier->id }}</td>
                    <td>{{ $courier->name }}</td>
                    <td>{{ $courier->user->username }}</td>
                    <td>{{ $courier->password }}</td>
                    <td>{{ $courier->phone_number }}</td>
                    <td>{{ $courier->zone->name}}</td>
                    <td>{{ $courier->address}}</td>
                    <td>
                        <div class="d-flex">
                            <a href="{{ route('couriers.edit', ['courier'=>$courier->id]) }}"
                               data-toggle="tooltip"
                               class="btn btn-light btn-sm" title="@lang('courier.edit')">
                                <i class="fa fa-edit"></i></a>
                            <form class="delete-form"
                                  action="{{ route('couriers.destroy', ['courier' => $courier->id]) }}"
                                  method="post">
                                {{ csrf_field() }}
                                {{ method_field('DELETE') }}
                            </form>
                            @component('bootstrap::modal',[
                                'id' => 'deleteCourier-'.$courier->id
                            ])
                                @slot('title')
                                    Delete this Courier?
                                @endslot
                                This is irreversible, all his information will be deleted permanently!
                                @slot('footer')
                                    <button class="btn btn-outline-secondary"
                                            data-dismiss="modal">@lang('common.cancel')</button>
                                    <button class="btn btn-danger ml-auto" type="button"
                                            data-delete="{{ $courier->id }}"><i
                                                class="fa fa-trash"></i> @lang('courier.delete')
                                    </button>
                                @endslot
                            @endcomponent
                            <span data-toggle="modal" data-target="#deleteCourier-{{ $courier->id }}">
                                <button class="btn btn-light btn-sm" title="@lang('courier.delete')" type="button"
                                        data-toggle="tooltip"><i class="fa fa-trash"></i></button>
                            </span>
                        </div>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection