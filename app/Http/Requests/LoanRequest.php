<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoanRequest extends FormRequest
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
            'account_number'            => 'required|exists:accounts,account_number',
            'principal'                 => 'required|min:1',
            'interest'                  => 'required|min:1',
            'daily_repayment_amount'    => 'required|min:1',
            'weekly_repayment_amount'   => 'required|min:1',
            'duration'                  => 'required|min:1',
            'start_date'                => 'required|date',
            'end_date'                  => 'required|date',
            // 'agent'                     => 'required|exists:users,id',
        ];
    }
}
