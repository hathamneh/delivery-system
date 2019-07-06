<form action="{{ route('clients.update', ['client' => $client, 'section' => 'emails']) }}"
      method="post">
    {{ csrf_field() }}
    {{ method_field('put') }}
    @include("clients.form.emails")

    <button class="btn btn-primary"><i class="fa-save"></i> @lang('client.save')
    </button>

</form>
