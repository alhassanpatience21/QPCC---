<?php

namespace App\Http\Requests;

use App\Models\Account;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class AccountRequest extends FormRequest
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
            'first_name'                    => 'required',
            'other_names'                   => 'nullable',
            'last_name'                     => 'required',
            'gender'                        => 'required|in:Male,Female',
            'date_of_birth'                 => 'nullable|date|before:today',
            'photo'                         => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'phone_number_one'              => [
                'nullable',
                Rule::unique('accounts', 'phone_number_one')->ignore($this->account)
            ],
            'phone_number_two'              => 'nullable',
            'registration_date'             => 'required|date|before:tomorrow',
            'residential_address'           => 'nullable',
            'landmark'                      => 'nullable',
            'house_number'                  => 'nullable',
            'employer'                      => 'nullable',
            'full_name_of_next_of_kin'      => 'nullable',
            'phone_number_of_next_of_kin'   => 'nullable|numeric',
            'payment_amount'                => request()->account_type == Account::SUSU ? 'required|numeric|min:1' : 'nullable|numeric|min:0',
            'passbook'                      => 'nullable|numeric|min:0',
            'account_type'                  => 'required',
        ];
    }
}
