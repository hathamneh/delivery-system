<?php

namespace App\Http\Requests;

use App\Role;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreShipmentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->user()->isAuthorized('shipments', Role::UT_CREATE);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'shipment_client.type' => 'required',
            'shipment_client.account_number' => 'required_if:shipment_client.type,client',
            'shipment_client.national_id' => 'required_if:shipment_client.type,guest',
            'shipment_client.name' => 'required_if:shipment_client.type,guest',
            'shipment_client.phone_number' => 'required_if:shipment_client.type,guest',
            'shipment_client.address_id' => 'required_if:shipment_client.type,guest|exists:addresses,id',
            'waybill' => 'required|unique:shipments|integer',
            'delivery_date' => 'required',
            'shipment_value' => 'required',
            'phone_number' => 'required',
            'address_from_zones' => 'required',
            'service_type' => [
                Rule::in(['nextday', 'sameday']),
            ],
            'delivery_cost_lodger' => [
                Rule::in(['client', 'courier']),
            ],
        ];
    }
}
