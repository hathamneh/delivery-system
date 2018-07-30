<div class="row">
    @if ($errors->any())
        <div class="col-md-offset-2 col-md-10">
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif
    <div class="col-md-2">
        <ul class="nav nav-pills flex-row flex-md-column mb-2" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="personal-tab" data-toggle="tab" href="#personal"
                   role="tab" aria-controls="personal" aria-selected="true">@lang('client.personal')</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="accounting-tab" data-toggle="tab" href="#accounting"
                   role="tab" aria-controls="accounting" aria-selected="false">@lang('client.accounting')</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="attachments-tab" data-toggle="tab" href="#attachments"
                   role="tab" aria-controls="attachments" aria-selected="false">@lang('client.attachments')</a>
            </li>
        </ul>
    </div>
    <div class="col-md-10">
        <div class="tab-content">
            <div class="tab-pane active show fade" role="tabpanel" aria-labelledby="personal-tab" id="personal">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('clients.update', ['client' => $client]) }}" method="post">
                            {{ csrf_field() }}
                            {{ method_field('put') }}
                            @include("clients.form.personal")
                            <hr>
                            @include('clients.form.urls')
                            <button class="btn btn-primary"><i class="fa-save"></i> @lang('client.save')</button>

                        </form>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" role="tabpanel" aria-labelledby="accounting-tab" id="accounting">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('clients.update', ['client' => $client]) }}" method="post">
                            {{ csrf_field() }}
                            {{ method_field('put') }}
                            @include('clients.form.zone')
                            <hr>
                            @include('clients.form.bank')
                            <hr>
                            @include('clients.form.chargedFor')
                            <button class="btn btn-primary"><i class="fa-save"></i> @lang('client.save')</button>

                        </form>
                    </div>
                </div>

            </div>
            <div class="tab-pane fade" role="tabpanel" aria-labelledby="attachments-tab"
                 id="attachments">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('clients.update', ['client' => $client]) }}" method="post"
                              enctype="multipart/form-data">
                            @include('clients.form.attachments')
                            <button class="btn btn-primary"><i class="fa-save"></i> @lang('client.save')</button>

                        </form>
                    </div>
                </div>

            </div>

        </div>
    </div>
</div>