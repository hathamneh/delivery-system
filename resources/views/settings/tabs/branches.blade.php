@component('bootstrap::modal',[
               'id' => 'addBranchModal'
           ])
    @slot('title')
        @lang("branch.new")
    @endslot
    <form action="{{ route('branches.store') }}" method="post">
        @csrf

        <div class="form-group">
            <label for="name">@lang('branch.name')</label>
            <input type="text" name="name" id="name" class="form-control" placeholder="@lang("branch.name")">
        </div>
        <div class="form-group">
            <label for="address">@lang('branch.address')</label>
            <textarea name="address" id="address" class="form-control" placeholder="@lang("branch.address")"></textarea>
        </div>
        <div class="form-group">
            <div class="custom-control custom-checkbox">
                <input type="checkbox" class="custom-control-input" id="is_main" name="is_main">
                <label class="custom-control-label" for="is_main">@lang("branch.is_main")</label>
            </div>
        </div>

        <div class="d-flex flex-row-reverse w-100 mt-3 pt-3 border-top">
            <button class="btn btn-primary" type="submit">@lang('branch.create') <i
                        class="fa fa-arrow-right"></i>
            </button>
            <button class="btn btn-outline-secondary mr-auto"
                    data-dismiss="modal">@lang('common.cancel')</button>
        </div>
    </form>
@endcomponent

<div class="container mt-5">
    <div class="d-flex mb-4">
        <button class="btn btn-primary ml-auto" data-toggle="modal"
                data-target="#addBranchModal"><i class="fa-plus-circle"></i> @lang('branch.new')</button>
    </div>
    <div class="table-responsive">
        <table class="table table-hover">
            <thead>
            <tr>
                <th>@lang('branch.name')</th>
                <th>@lang('branch.address')</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            @foreach($branches as $branch)
                @php /** @var \App\Branch $branch */ @endphp
                <tr>
                    <td>{{ $branch->name }}</td>
                    <td>{!! nl2br($branch->address) !!}</td>
                    <td>
                        <button class="btn btn-sm btn-outline-secondary" type="button" data-toggle="modal"
                                data-target="#editBranchModal-{{ $branch->id }}"><i class="fa-edit"></i></button>
                        @component('bootstrap::modal',[
                               'id' => 'editBranchModal-' . $branch->id
                           ])
                            @slot('title')
                                @lang("branch.edit")
                            @endslot
                            <form action="{{ route('branches.update', [$branch]) }}" method="post">
                                @csrf
                                @method("put")

                                <div class="form-group">
                                    <label for="name">@lang('branch.name')</label>
                                    <input type="text" name="name" id="name" class="form-control"
                                           placeholder="@lang("branch.name")" value="{{ $branch->name }}">
                                </div>
                                <div class="form-group">
                                    <label for="address">@lang('branch.address')</label>
                                    <textarea name="address" id="address" class="form-control"
                                              placeholder="@lang("branch.address")">{{ $branch->address }}</textarea>
                                </div>
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="is_main-{{ $branch->id }}"
                                           name="is_main" {{ !$branch->is_main ?: "checked" }}>
                                    <label class="custom-control-label"
                                           for="is_main-{{ $branch->id }}">@lang("branch.is_main")</label>
                                </div>

                                <div class="d-flex flex-row-reverse w-100 mt-3 pt-3 border-top">
                                    <button class="btn btn-primary" type="submit">@lang('branch.save') <i
                                                class="fa fa-arrow-right"></i>
                                    </button>
                                    <button class="btn btn-outline-secondary mr-auto"
                                            data-dismiss="modal">@lang('common.cancel')</button>
                                </div>
                            </form>
                        @endcomponent
                        @if(!$branch->is_main)
                            <button class="btn btn-sm btn-outline-danger" type="button" data-toggle="modal"
                                    data-target="#deleteBranch-{{ $branch->id }}"><i class="fa-trash"></i></button>
                            @component('layouts.components.deleteItem', [
                                            'name' => 'branch',
                                            'id' => $branch->id,
                                            'action' => route('branches.destroy', [$branch])
                                        ])@endcomponent
                        @endif
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>