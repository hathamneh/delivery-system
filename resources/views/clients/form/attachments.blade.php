@php /** @var App\Client $client */ @endphp

@if(session('alert'))
    @component('bootstrap::alert', [
        'type' => session('alert')->type ?? "primary",
        'dismissible' => true,
        'animate' => true,
       ])
        {{ session('alert')->msg }}
    @endcomponent
@endif

@if($client->attachments->count())
    <label class="control-label">@lang('client.files')</label>
    <ul class="list-group mb-3">
        @foreach($client->attachments as $attachment)
            <li class="list-group-item" data-id="{{ $attachment->id }}">
                <div class="d-flex align-items-center">
                    <i class="fa-file mr-2" style="font-size: 1.5rem"></i> {{ $attachment->name }}
                    <div class="attachment__file-name">
                    </div>
                    <div class="attachment__actions ml-auto">
                        <div class="btn-group">
                            <a href="{{ $attachment->url }}" class="btn btn-dark btn-sm"><i
                                        class="fa-download mr-1"></i> Download</a>
                            <button type="button" class="btn btn-danger btn-sm delete-attachment"
                                    data-toggle="modal" data-target="#deleteAttachment-{{ $attachment->id }}"><i
                                        class="fa-trash"></i></button>
                        </div>
                    </div>
                </div>
            </li>
        @endforeach
    </ul>
    @foreach($client->attachments as $attachment)
        @component('bootstrap::modal',[
                   'id' => 'deleteAttachment-'.$attachment->id
               ])
            @slot('title')
                @lang('client.deleteAttachment')?
            @endslot
            Are you sure you want to delete this attachment
            @slot('footer')
                <button class="btn btn-outline-secondary"
                        data-dismiss="modal">@lang('common.cancel')</button>
                <form action="{{ route('attachment.destroy', [$attachment->id]) }}" method="post">
                    {{ csrf_field() }}
                    {{ method_field('DELETE') }}
                    <button class="btn btn-danger ml-auto" type="submit"><i
                                class="fa fa-trash"></i> @lang('client.delete_attachment')
                    </button>
                </form>
            @endslot
        @endcomponent
    @endforeach
    @else
    <p class="py-4 text-muted text-center">
        No Attachments!
    </p>
@endif
