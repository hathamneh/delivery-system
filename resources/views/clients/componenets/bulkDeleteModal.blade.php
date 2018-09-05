@component('bootstrap::modal',[
        'id' => "bulkDeleteAddressModal"
    ])
    @slot('title')
        Delete addresses customizations
    @endslot
    <p>Are you sure you want to delete customization of selected addresses?</p>
    @slot('footer')
        <form action="{{ route('clients.addresses.bulkDestroy', ['client' => $client, 'customZone' => $selected])  }}" method="post" class="w-100">
            {{ csrf_field() }}
            {{ method_field('delete') }}
            <input type="hidden" name="addresses" value="">
            <div class="d-flex flex-row-reverse">
                <button type="submit" class="btn btn-danger">Confirm</button>
                <button type="button" class="btn btn-outline-secondary mr-auto" data-dismiss="modal">Cancel</button>
            </div>
        </form>
    @endslot
@endcomponent
