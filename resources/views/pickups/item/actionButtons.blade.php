<div class="pickup-actions">
    @if(auth()->user()->isCourier() || auth()->user()->isAdmin())
        <button type="button" data-toggle="modal" data-target="#pickupActionsModal-{{ $pickup->id }}"
                class="btn btn-light btn-sm actions-btn">
            <i class="fa-cogs"></i> @lang('common.actions')
        </button>
    @endif
    @can('update', $pickup)
        <a href="{{ route('pickups.edit', ['pickup'=> $pickup->id]) }}"
           title="@lang('pickup.edit')"
           data-toggle="tooltip" class="btn btn-light btn-sm">
            <i class="fa-pencil-alt"></i>
        </a>
    @endcan
    @can('delete', $pickup)
        <button class="btn btn-light text-danger btn-sm" type="button" data-toggle="modal"
                data-target="#deletePickup-{{ $pickup->id }}" data-toggle-tooltip
                title="@lang('pickup.delete')"><i
                    class="fa fa-trash"></i>
        </button>
    @endcan
</div>