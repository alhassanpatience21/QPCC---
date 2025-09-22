<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Traits\SmsTrait;
use App\Models\Commission;
use App\Traits\ImageUpload;
use App\Traits\LogCommission;
use App\Http\Requests\AccountRequest;
use RealRashid\SweetAlert\Facades\Alert;
use Haruncpi\LaravelIdGenerator\IdGenerator;

class AccountController extends Controller
{
    use ImageUpload, SmsTrait, LogCommission;

    public function index()
    {
        $accounts = Account::all();
        return view('accounts.index', compact('accounts'));
    }

    public function create()
    {
        return view('accounts.create');
    }

    public function store(AccountRequest $request)
    {
        $id = IdGenerator::generate(['table' => 'accounts', 'field' => 'account_number', 'length' =>  8, 'prefix' => 'DV00']);
        $account = new Account();
        $account->account_number = $id;
        if ($request->file('photo')) {
            $cover = $request->file('photo');
            $filenmae = $this->upload($cover, 'profile');
            $account->photo = $filenmae;
        }

        $this->storedata($request, $account);

        $account->saveOrFail();

        if ($request->passbook != 0) {
            // log passbook fee commission
            $this->logCommission($account, $request->passbook, Commission::PASS_BOOK);
        }

        $this->sendSmsNotification($account);

        Alert::success('Success', 'Account created successfully');
        return redirect()->route('accounts.index');
    }

    public function show(Account $account)
    {
        return view('accounts.show', compact('account'));
    }

    public function update(AccountRequest $request, Account $account)
    {
        $filenmae = $account->photo;
        if ($request->file('photo')) {
            $cover = $request->file('photo');
            $filenmae = $this->upload($cover, 'profile');
        }

        $account->photo = $filenmae;
        $this->storedata($request, $account);

        Alert::success('Success', 'Account updated successfully');
        return redirect()->back();
    }

    public function storedata($request, $account)
    {
        $account->first_name = $request->first_name;
        $account->other_names = $request->other_names;
        $account->last_name = $request->last_name;
        $account->gender = $request->gender;
        $account->date_of_birth = $request->date_of_birth;
        $account->phone_number_one = $request->phone_number_one;
        $account->phone_number_two = $request->phone_number_two;
        $account->house_number = $request->house_number;
        $account->residential_address = $request->residential_address;
        $account->landmark = $request->landmark;
        $account->employer = $request->employer;
        $account->fullname_of_next_of_kin = $request->full_name_of_next_of_kin;
        $account->phone_number_of_next_of_kin = $request->phone_number_of_next_of_kin;
        $account->payment_amount = $request->payment_amount;
        $account->id_type = $request->id_type;
        $account->id_number = $request->id_number;
        $account->sms_option = $request->sms_option;
        $account->registration_date = $request->registration_date;
        $account->savings_account = ($request->account_type == Account::SAVINGS) ? 1 : 0;
        $account->susu_account = ($request->account_type == Account::SUSU) ? 1 : 0;
        $account->registered_by = auth()->id();
        $account->saveOrFail();
    }

    public function sendSmsNotification($account)
    {
        if ($account->sms_option) {
            $number = array($account->phone_number_one);
            $message = 'Welcome ' . $account->account_name . ', your Account Number is ' . $account->account_number . ' We appreciate you willingness to do business with Dougy Star. Helpline:+233 24 444 8865';
            return $this->collector($message, $number);
        }
    }
}
