<div class="form-row">
    <div class="col-sm-12">
        <label for="bank_name" class="control-label">@lang('client.bank.info')</label>
    </div>
    <div class="form-group col-sm-6">
        <input type="text" name="bank[name]" id="bank_name" value="{{ old('bank.name') }}"
               placeholder="@lang('client.bank.name')" class="form-control">
    </div>
    <div class="form-group col-sm-6">
        <input type="text" name="bank[account_number]" id="bank_account_number"
               value="{{ old('bank.account_number') }}"
               placeholder="@lang('client.bank.account_number')" class="form-control">
    </div>
    <div class="form-group col-sm-6">
        <input type="text" name="bank[holder_name]" id="bank_holder_name"
               value="{{ old('bank.holder_name') }}"
               placeholder="@lang('client.bank.holder_name')" class="form-control">
    </div>
    <div class="form-group col-sm-6">
        <input type="text" name="bank[iban]" id="bank_iban" value="{{ old('bank.iban') }}"
               placeholder="@lang('client.bank.iban')" class="form-control">
    </div>
</div>