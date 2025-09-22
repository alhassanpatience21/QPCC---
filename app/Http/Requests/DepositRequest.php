<?php

namespace App\Http\Requests;

use App\Models\Account;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class DepositRequest extends FormRequest
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
            "account_number"        => 'required|exists:accounts,account_number',
            "date_of_deposit"       => 'required|before:tomorrow',
            "amount"                => 'required|numeric|min:1',
            "number_of_deposits"    => 'nullable|numeric|min:1',
            "account_type"          => 'required', Rule::in([Account::SUSU, Account::SAVINGS]),
        ];
    }
}
