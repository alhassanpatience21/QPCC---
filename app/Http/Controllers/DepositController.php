<?php
namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Account;
use App\Models\Deposit;
use App\Traits\SmsTrait;
use App\Models\Commission;
use Illuminate\Http\Request;
use App\Traits\LogCommission;
use App\Models\AccountTrialBalance;
use App\Http\Requests\DepositRequest;
use App\Repositories\AccountRpository;
use RealRashid\SweetAlert\Facades\Alert;
class DepositController extends Controller
{
    use SmsTrait, LogCommission;
    // public function index(Request $request, AccountRpository $accountRpository)
    // {
    //     if ($request->get('date')) {
    //         $agents = User::where('email', '!=', 'admin@sageitservices.com')->get();
    //         $deposits = $accountRpository
    //             ->deposits()
    //             ->where('date_of_deposit', $request->date);
    //         return view('deposits.details', compact('deposits', 'agents'));
    //     }
    //     $deposits = $accountRpository->deposits();
    //     return view('deposits.index', compact('deposits'));
    // }

    public function index(Request $request, AccountRpository $accountRpository)
    {
        if ($request->get('date')) {
            $agents = User::where('email', '!=', 'admin@sageitservices.com')->get();
            $deposits = $accountRpository
                ->depositAll()
                ->where('date_of_deposit', $request->date);
            return view('deposits.details', compact('deposits', 'agents'));
        }

        // Get deposit summary totals for cards at the top
        $summary = $accountRpository->depositSummary();

        // Get recent deposits for display
        $recentDeposits = $accountRpository->recentDeposits();

        return view('deposits.index', compact('summary', 'recentDeposits'));
    }



    public function create()
    {
        $accounts = Account::get();
        return view('deposits.create', compact('accounts'));
    }

    public function store(DepositRequest $request)
    {
        $counter = $request->get('number_of_deposits', 1);
        for ($i = 0; $i < $counter; $i++) {
            $deposit = new Deposit;
            $deposit->account_number = $request->account_number;
            $deposit->date_of_deposit = $request->date_of_deposit;
            $deposit->amount = $request->amount;
            $deposit->account_type = $request->account_type;
            $deposit->approval_status = 0;
            $deposit->entered_by = auth()->id();
            $deposit->saveOrFail();

            $this->logTrailBalance($deposit);
        }

        Alert::success('Success', 'Deposit recorded successfully pending approval');
        return redirect()->route('deposits.index');
    }

    public function show(Deposit $deposit)
    {
        return view('deposits.show', compact('deposit'));
    }

    public function sendSmsNotification($deposit, $amount)
    {
        $account = $deposit->account;
        $number = $account->phone_number_one;
        if ($account->sms_option) {
            $message =  moneyFormat($amount) . ' has been credited to your ' . $account->account_type . '  a/c ******' . substr($account->account_number, 4) . ' on ' . $deposit->date_of_deposit . '. A/C Bal: ' . $account->balance . '. Helpline:+233 24 444 8865';
            return $this->collector($message, $number);
        }
    }

    public function logTrailBalance($deposit)
    {
        $trailBalance = new AccountTrialBalance();
        $trailBalance->transaction_date = $deposit->date_of_deposit;
        $trailBalance->transaction_id = $deposit->id;
        $trailBalance->amount = $deposit->amount;
        $trailBalance->account_type = $deposit->account_type;
        $trailBalance->account_number = $deposit->account_number;
        $trailBalance->balance = floatval(preg_replace('/[^\d.]/', '', $deposit->account->actual_balance));
        $trailBalance->description = 'credit';
        $trailBalance->transaction_by = $deposit->entered_by;
        $trailBalance->approval_status = 0;
        $trailBalance->saveOrFail();
    }

    public function commissions($deposit)
    {
        $account = $deposit->account;
        $amount = $account->base_amount;
        if ($account->commission_for_deposit == 0 && $account->deposits->count() > 0) {
            return $this->logCommission($account, $amount, Commission::DEPOSIT);
        }
    }

    public function approve(Deposit $deposit, $counter = 1)
    {
        // $account = $deposit->account;
        // if (!$account->passbookStatus) {
        // if ($deposit->amount > $account->passbookBalance) {
        // $deposit->amount -= $account->passbookBalance;
        // }

        // log passbook fee commission
        // $this->logCommission($account, $account->passbookBalance, Commission::PASS_BOOK);
        // }

        $deposit->approval_status = 1;
        $deposit->save();

        $trailBalance = $deposit->trailBalance;
        $trailBalance->amount = $deposit->amount;
        $trailBalance->balance = $deposit->account->actual_balance;
        $trailBalance->approval_status = 1;
        $trailBalance->save();

        if ($deposit->account_type == Account::SUSU) {
            $this->commissions($deposit);
        }

        if ($counter == 1) {
            $this->sendSmsNotification($deposit, $deposit->amount);

            Alert::success('Success', 'Deposit approved successfully');
            return redirect()->back();
        }

        return true;
    }

    public function destroy(Deposit $deposit)
    {
        $deposit->trailBalance()->delete();

        $deposit->delete();

        Alert::success('Success', 'Deposit removed successfully');

        return redirect()->back();
    }

    public function approveAll(Request $request)
    {
        if ($request->query('agent')) {
            $deposits = Deposit::where('approval_status', 0)->where('entered_by', $request->agent)->get();
        } else {
            $deposits = Deposit::where('approval_status', 0)->get();
        }
        foreach ($deposits as $deposit) {
            $this->approve($deposit, $deposits->count());
        }

        foreach ($deposits->unique('account_number') as  $deposit) {
            $amount = $deposits->where('account_number', $deposit->account_number)->sum('amount');
            $this->sendSmsNotification($deposit, $amount);
        }

        Alert::success('Success', 'All Deposits approved successfully');
        return redirect()->back();
    }

    public function approveSelected(Request $request)
    {
        $deposits = $request->deposits;
        if (isset($request['deposits'])) {
            foreach ($deposits as $id) {
                $deposit = Deposit::find($id);
                if (isset($_POST['approve_selected'])) {
                    $this->approve($deposit, 1);
                }
                if (isset($_POST['remove'])) {
                    $deposit->trailBalance()->delete();
                    $deposit->delete();
                }
            }

            if (isset($_POST['remove'])) {
                Alert::success('Success', 'Selected deposits removed successfully');
            } else {
                Alert::success('Success', 'Selected deposits approved successfully');
            }
            return redirect()->back();
        }

        Alert::error('Warning', 'Nothing was selected');
        return redirect()->back();
    }

    public function approvals()
    {
        $users = User::withTrashed()->get();
        return view('deposits.approvals', compact('users'));
    }
}
