<div class="row pickups-list">
    @foreach($pickups as $pickup)
        <?php /** @var \App\Pickup $pickup */ ?>
        <div class="col-md-4 col-sm-6 mix pickup-item pickup-{{ $pickup->status }}">
            <div class="card {{ $pickup->statusContext('card') }}">
                <div class="card-body">
                    bbb
                </div>
                <div class="card-footer">
                    <div class="pickup-status">
                        {!!  $pickup->statusContext('text')  !!}
                    </div>
                    <div class="pickup-actions ml-auto">
                        <a href="{{ route('pickups.edit', ['pickup'=> $pickup->id]) }}" title="@lang('pickup.edit')" data-toggle="tooltip"
                           class="btn btn-light btn-sm"><i class="fa-pencil-alt"></i></a>
                        <a href="{{ route('pickups.edit', ['pickup'=> $pickup->id]) }}" title="@lang('pickup.history')" data-toggle="tooltip"
                           class="btn btn-light btn-sm"><i class="fa-history"></i></a>
                        <form class="delete-form"
                              action="{{ route('pickups.destroy', ['pickup' => $pickup->id]) }}"
                              method="post">
                            {{ csrf_field() }}
                            {{ method_field('DELETE') }}
                        </form>
                        @component('bootstrap::modal',[
                            'id' => 'deletePickup-'.$pickup->id
                        ])
                            @slot('title')
                                Delete this pickup?
                            @endslot
                            This is irreversible, all his information will be deleted permanently!
                            @slot('footer')
                                <button class="btn btn-outline-secondary"
                                        data-dismiss="modal">@lang('common.cancel')</button>
                                <button class="btn btn-danger ml-auto" type="button"
                                        data-delete="{{ $pickup->id }}"><i
                                            class="fa fa-trash"></i> @lang('pickup.delete')
                                </button>
                            @endslot
                        @endcomponent
                        <span data-toggle="modal" data-target="#deletePickup-{{ $pickup->id }}">
                                <button class="btn btn-light text-danger btn-sm" title="@lang('pickup.delete')" type="button"
                                        data-toggle="tooltip"><i class="fa fa-trash"></i></button>
                            </span>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>