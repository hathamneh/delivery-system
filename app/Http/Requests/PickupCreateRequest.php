<?php

namespace App\Http\Requests;

use App\Role;
use Illuminate\Foundation\Http\FormRequest;

class PickupCreateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->user()->isAuthorized('pickups', Role::UT_CREATE);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'is_guest' => 'required',
            'client_account_number' => 'required_if:is_guest,0',
            'client_national_id' => 'required_if:is_guest,1',
            'guest_name' => 'required_if:is_guest,1',
            'guest_country' => 'required_if:is_guest,1',
            'guest_city' => 'required_if:is_guest,1',
            'guest_address_id' => 'required_if:is_guest,1',
            'client_name' => 'required',
            'phone_number' => 'required',
            'pickup_from' => 'required',
            'available_day' => 'required',
            'time_start' => 'required',
            'time_end' => 'required',
            'expected_packages_number' => 'required',
        ];
    }
}
