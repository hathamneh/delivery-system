@php /** @var App\Client $client */ @endphp

<div class="form-row">
    <div class="col-sm-12">
        <label for="bank_name" class="control-label">@lang('client.bank.info')</label>
    </div>
    <div class="form-group col-sm-6">
        <input type="text" name="bank[name]" id="bank_name" value="{{ $client->bank->name ?? old('bank.name') }}"
               placeholder="@lang('client.bank.name')" class="form-control">
    </div>
    <div class="form-group col-sm-6">
        <input type="text" name="bank[account_number]" id="bank_account_number"
               value="{{ $client->bank->account_number ?? old('bank.account_number') }}"
               placeholder="@lang('client.bank.account_number')" class="form-control">
    </div>
    <div class="form-group col-sm-6">
        <input type="text" name="bank[holder_name]" id="bank_holder_name"
               value="{{ $client->bank->holder_name ?? old('bank.holder_name') }}"
               placeholder="@lang('client.bank.holder_name')" class="form-control">
    </div>
    <div class="form-group col-sm-6">
        <input type="text" name="bank[iban]" id="bank_iban" value="{{ $client->bank->iban ?? old('bank.iban') }}"
               placeholder="@lang('client.bank.iban')" class="form-control">
    </div>
</div>