<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReportRequest extends FormRequest
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
        $dates = (request()->get('type') != 'sms') ? 'required' : 'nullable';
        return [
            'type'              => 'required',
            'options'           => 'required',
            'from'              => "$dates|date",
            // 'account_number'    => (request()->get('options') == 'Individual') ? 'required' : 'nullable',
            // 'agent'             => (request()->get('options') == 'Agent') ? 'required' : 'nullable',
            'to'                => "$dates |date",
        ];
    }
}
