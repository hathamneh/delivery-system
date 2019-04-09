@component('bootstrap::modal',[
                        'id' => 'customizeService-' . $service->id
                    ])
    @slot('title')
        Customize <b>{{ $service->name }}</b> only for <b>{{ $client->name }}</b>
    @endslot

    <form action="{{ route('clients.services.'.($custom ? 'update':'store'), [$client, $service]) }}" method="post">
        {{ csrf_field() }}
        {{ $custom ? method_field('put') : "" }}

        <div class="form-group">
            <label for="price">New Custom Price</label>
            <input type="number" class="form-control" name="price" id="price" step="0.01">
        </div>

        <div class="d-flex flex-row-reverse">
            <button class="btn btn-primary ml-auto" type="submit">@lang('common.save')</button>
            <button class="btn btn-outline-secondary" data-dismiss="modal">@lang('common.cancel')</button>
        </div>
    </form>
@endcomponent
