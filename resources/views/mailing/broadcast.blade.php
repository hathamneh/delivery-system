<button class="btn btn-primary" data-toggle="modal" data-target="#broadcastMailModal"><i
            class="fa-paper-plane"></i> @lang('emails.broadcast')</button>
<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="broadcastMailButton"
     id="broadcastMailModal" aria-hidden="true">
    <form action="{{ route('emails.broadcast') }}" method="post">
        {{ csrf_field() }}
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">@lang('emails.broadcast')</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="broadcast_for">@lang('emails.broadcast_to')</label>
                            <select name="broadcast_for" id="broadcast_for" class="form-control" required>
                                <option value="clients">@lang('client.label')</option>
                                <option value="couriers">@lang('courier.label')</option>
                            </select>
                        </div>
                        <div class="form-group col-md-12">
                            <label for="broadcast_subject">@lang('emails.broadcast_subject')</label>
                            <input type="text" class="form-control" name="broadcast_subject" id="broadcast_subject"
                                   placeholder="@lang('emails.broadcast_subject')" required>
                        </div>
                        <div class="form-group col-md-12">
                            <label for="mailEditor">@lang('emails.broadcast_body')</label>
                            <textarea name="broadcast_body" id="mailEditor" cols="30" rows="10" required></textarea>
                        </div>
                    </div>
                </div>

                <div class="modal-footer d-flex align-items-center">
                    <small class="text-danger">Attention, clicking send button will broadcast the message to all selected group. Be careful.</small>
                    <button class="btn btn-primary ml-auto" type="submit">@lang('emails.send') <i
                                class="ml-1 fa-paper-plane"></i></button>
                </div>
            </div>
        </div>
    </form>
</div>
