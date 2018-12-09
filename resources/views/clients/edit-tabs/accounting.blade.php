
<form action="{{ route('clients.update', ['client' => $client, 'section' => 'accounting']) }}"
      method="post">
    {{ csrf_field() }}
    {{ method_field('put') }}
    @include('clients.form.zone')
    <hr>
    @include('clients.form.bank')
    <hr>
    @include('clients.form.chargedFor')
    <hr>
    @include('clients.form.limits')
    <hr>
    <button class="btn btn-primary"><i class="fa-save"></i> @lang('client.save')
    </button>
</form>
