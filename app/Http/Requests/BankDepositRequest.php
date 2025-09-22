<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BankDepositRequest extends FormRequest
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
            'date_of_deposit'   => 'required',
            'account_number'    => 'required|exists:bank_accounts,account_number',
            'amount'            => 'required|numeric|min:1',
            'deposited_by'      => 'required',
            'slip_number'       => 'required',
            'mode_of_deposit'   => 'required',

        ];
    }
}
