<?php

namespace App\Http\Requests;

use App\Rules\PhoneNumber;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreCourierRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'                 => 'required',
            'phone_number'         => [new PhoneNumber()],
            'email'                => 'nullable|email|unique',
            'zone_id'              => 'required|exists:zones,id',
            'category'             => [
                'required',
                Rule::in([1, 2]),
            ],
            'courier_files.*.file' => 'file|max:50000|mimes:jpg,jpeg,png,gif,pdf,doc,docx,xsl,xslx'
        ];
    }
}
