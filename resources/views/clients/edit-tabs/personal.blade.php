<form action="{{ route('clients.update', ['client' => $client, 'section' => 'personal']) }}"
      method="post">
    {{ csrf_field() }}
    {{ method_field('put') }}
    @include("clients.form.personal")
    <hr>
    @include('clients.form.zone')
    <hr>
    @include('clients.form.urls')
    <hr>
    @include('clients.form.notesForCourier')
    <button class="btn btn-primary"><i class="fa-save"></i> @lang('client.save')
    </button>

</form>
