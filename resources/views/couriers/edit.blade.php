@extends('layouts.couriers')


@section('breadcrumbs')
    {{ Breadcrumbs::render('couriers') }}
@endsection

@section('pageTitle')
    <i class='fa-user-tie'></i> @lang("courier.label")
@endsection

@section('content')
    @include("couriers.tabs")
    <div class="container mt-5">
        <form action="{{ route('couriers.update', ['courier' => $courier]) }}" method="post"
              enctype="multipart/form-data">
            {{ csrf_field() }}
            {{ method_field('PUT') }}
            @include('couriers.form')
        </form>
        @if($courier->attachments->count())
            @foreach($courier->attachments as $attachment)
                @component('bootstrap::modal',[
                           'id' => 'deleteAttachment-'.$attachment->id
                       ])
                    @slot('title')
                        @lang('courier.deleteAttachment')?
                    @endslot
                    Are you sure you want to delete this attachment
                    @slot('footer')
                        <button class="btn btn-outline-secondary"
                                data-dismiss="modal">@lang('common.cancel')</button>
                        <form action="{{ route('attachment.destroy', [$attachment->id]) }}" method="post">
                            {{ csrf_field() }}
                            {{ method_field('DELETE') }}
                            <button class="btn btn-danger ml-auto" type="submit"><i
                                        class="fa fa-trash"></i> @lang('courier.delete_attachment')
                            </button>
                        </form>
                    @endslot
                @endcomponent
            @endforeach
        @endif
    </div>
@endsection
