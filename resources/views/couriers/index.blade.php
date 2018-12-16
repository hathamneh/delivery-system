@extends('layouts.couriers')


@section('breadcrumbs')
    {{ Breadcrumbs::render('couriers') }}
@endsection

@section('pageTitle')
    <i class='fa-user-tie'></i> @lang("courier.label")
@endsection

@section('content')
    <div class="container">
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
            <table class="table table-hover dataTable">
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
                        <td>{{ $courier->zones->count() ? $courier->zones->pluck('name')->implode(',') : '' }}</td>
                        <td>{{ $courier->address}}</td>
                        <td>
                            <div class="btn-group">
                                <a href="{{ route('reports.index', ['courier'=>$courier->id]) }}"
                                   data-toggle="tooltip"
                                   class="btn btn-light btn-sm" title="@lang('reports.label')">
                                    <i class="fa-reports"></i></a>
                                <a href="{{ route('couriers.edit', ['courier'=>$courier->id]) }}"
                                   data-toggle="tooltip"
                                   class="btn btn-light btn-sm" title="@lang('courier.edit')">
                                    <i class="fa fa-edit"></i></a>
                                <button class="btn btn-light btn-sm" type="button" data-toggle-tooltip title="@lang('courier.delete')"
                                        data-toggle="modal" data-target="#deleteCourier-{{ $courier->id }}">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </div>
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
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection