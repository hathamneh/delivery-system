@component('bootstrap::modal',[
        'id' => 'delete' . ucfirst($name) . '-' . $id
    ])
    @slot('title')
        Delete this item?
    @endslot
    This is irreversible, all related data will be deleted permanently!
    @slot('footer')
        <div class="d-flex flex-row-reverse w-100">
            <form action="{{ $action }}" method="post" class="ml-auto">
                {{ csrf_field() }}
                {{ method_field('DELETE') }}
                <button class="btn btn-danger" type="submit"><i
                            class="fa fa-trash"></i> @lang('common.delete')
                </button>
            </form>
            <button class="btn btn-outline-secondary"
                    data-dismiss="modal">@lang('common.cancel')</button>
        </div>
    @endslot
@endcomponent