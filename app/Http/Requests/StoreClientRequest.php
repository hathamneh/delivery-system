<?php

namespace App\Http\Requests;

use App\Role;
use App\Rules\PhoneNumber;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class StoreClientRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::user()->isAuthorized('clients', Role::UT_CREATE);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'trade_name'          => 'required|unique:clients,trade_name',
            'name'                => 'required',
            'phone_number'        => [ new PhoneNumber()],
            'email'               => 'required|email',
            'address.maps'        => 'nullable|url',
            'pickup_address.maps' => 'nullable|url',
            'urls.website'         => 'nullable|url',
            'urls.facebook'        => 'nullable|url',
            'urls.instagram'       => 'nullable|url',
            'zone_id'             => 'required|exists:zones,id',
            'category'            => [
                'required',
                Rule::in([1, 2]),
            ],
            'client_files.*.file'        => 'file|max:5000|mimes:jpg,jpeg,png,gif,pdf,doc,docx,xsl,xslx'
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'address.maps.url' => 'Address Google maps URL is invalid!',
            'address_pickup.maps.url' => 'Pickup address Google maps URL is invalid!',
            'urls.*.url'  => ':attribute URL is invalid!',
        ];
    }
}
