@include('accounting.shipments')
<br>
<table class="invoice__summery-table">
    <tbody>
    <tr>
        <th>@lang('accounting.client_due_for')</th>
        <td><span class="currency">@lang('common.jod')</span>{{ fnumber($invoice->due_for) }}
        </td>
    </tr>
    <tr>
        <th>@lang('accounting.client_due_from')</th>
        <td><span class="currency">@lang('common.jod')</span>{{ fnumber($invoice->due_from) }}
        </td>
    </tr>
    <tr>
        <th {{{ $invoice->terms_applied ? "rowspan='2'" : "" }}}>@lang('accounting.terms_applied')</th>
        <td>{{ $invoice->the_discount }}</td>
    </tr>
    @if($invoice->terms_applied)
        <tr>
            <td>
                <span class="currency">@lang('common.jod')</span>{{ fnumber($invoice->terms_applied) }}
            </td>
        </tr>
    @endif
    <tr>
        <th>@lang('accounting.pickups_fees')</th>
        <td>
            <span class="currency">@lang('common.jod')</span>{{ fnumber($invoice->pickup_fees) }}
        </td>
    </tr>
    <tr>
        <th>@lang('accounting.prepaid_cash')</th>
        <td>
            <span class="currency">@lang('common.jod')</span>{{ fnumber($invoice->pickups_prepaid_cash) }}
        </td>
    </tr>
    <tr>
        <th>@lang('client.payment_method_price')</th>
        <td>
            <b>(@lang('client.payment_methods.'.$client->paymentMethod->name))</b>
            <span class="currency">@lang('common.jod')</span>{{ fnumber($invoice->payment_method_price ?? 0) }}
        </td>
    </tr>
    </tbody>
    <tfoot>
    <tr>
        <th>@lang('accounting.total_net')</th>
        <td><span class="currency">@lang('common.jod')</span>{{ fnumber($invoice->total) }}</td>
    </tr>
    </tfoot>
</table>