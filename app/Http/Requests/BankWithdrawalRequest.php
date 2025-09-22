<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BankWithdrawalRequest extends FormRequest
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
            'date_of_withdrawal'    => 'required|date|before:tomorrow',
            'account_number'        => 'required|exists:bank_accounts,account_number',
            'amount'                => 'required|min:1|numeric',
            'cheque_number'         => 'required',
        ];
    }
}
