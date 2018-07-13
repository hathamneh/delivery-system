<div class="row">
    @foreach($pickups as $pickup)
        <?php /** @var \App\Pickup $pickup */ ?>
        <div class="col-md-4 col-sm-6 pickup-item">
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
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>