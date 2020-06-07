<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MpesaRequest extends FormRequest
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
            'mchwa' => [
                'sometimes',
                'required',
                'phone:ke',
                function ($attribute, $value, $fail) {
                    if (!verifySafaricomPhoneNo($value)) {
                        return $fail(__('Only Safaricom numbers are supported for bulk sms'));
                    }
                }
            ],
            'amount' => [
                'required',
                'numeric',
                'min:1',
                'max:90000'
            ]
        ];
    }

    public function attributes()
    {
        return [
            'mchwa' => 'phone number',
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
            'phone' => 'Please enter a kenyan phone number',
        ];
    }
}
