<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class WithdrawalRequest extends FormRequest
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
            "date_of_withdrawal"    => 'required|before:tomorrow',
            "amount"                => 'required|numeric|min:1|lte:maximum_withdrawal_amount',
        ];
    }
}
