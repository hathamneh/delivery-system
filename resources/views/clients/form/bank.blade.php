@php /** @var App\Client $client */ @endphp

<div class="form-row">
    <div class="col-sm-12">
        <h3 style="font-weight: bold;" class="mt-0">@lang('client.bank.info')</h3>
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
    <div class="form-group col-sm-6">
        <input type="text" name="bank[swift_code]" id="swift_code"
               value="{{ $client->bank->swift_code ?? old('bank.swift_code') }}"
               placeholder="@lang('client.bank.swift_code')" class="form-control">
    </div>
    <div class="w-100"></div>
    <div class="form-group col-sm-6">
        <label for="payment_method">@lang('client.payment_method')</label>
        <select name="payment_method" id="payment_method" class="form-control">
            <option value=""
                    disabled {{ empty(old('payment_method')) || !isset($client) ? 'selected' : '' }}>@lang('common.select')</option>
            @foreach($paymentMethods as $paymentMethod)
                <option value="{{ $paymentMethod->id }}" {{ isset($client) && $client->payment_method_id === $paymentMethod->id ? "selected" : "" }}>@lang('client.payment_methods.' . $paymentMethod->name)</option>
            @endforeach
        </select>
    </div>
    <div class="form-group col-sm-6">
        <label for="payment_method_price">@lang('client.payment_method_price')</label>
        <input type="number" step="any" class="form-control" name="payment_method_price" id="payment_method_price" placeholder="@lang('client.payment_method_price')"
               value="{{ old('payment_method_price') ?? $client->payment_method_price ?? 0 }}">
    </div>
</div>