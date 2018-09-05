@component('bootstrap::modal',[
        'id' => "deleteAddressModal-" . $address->id
    ])
    @slot('title')
        Delete address customization
    @endslot
    <p>Are you sure you want to delete customization of selected address?</p>
    @slot('footer')
        <form action="{{ route('clients.addresses.destroy', ['client' => $client, 'address' => $address,'customZone' => $selected])  }}"
              method="post" class="w-100">
            {{ csrf_field() }}
            {{ method_field('delete') }}
            <div class="d-flex flex-row-reverse">
                <button type="submit" class="btn btn-danger">Confirm</button>
                <button type="button" class="btn btn-outline-secondary mr-auto" data-dismiss="modal">Cancel</button>
            </div>
        </form>
    @endslot
@endcomponent
