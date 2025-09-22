<?php

use App\Models\User;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Auth::routes();

Route::middleware(['auth'])->group(function () {
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

    Route::get('users/{id}/activate', function ($id) {
        $user = User::where('id', $id)->withTrashed()->first();
        $user->deleted_at = null;
        $user->save();

        return redirect()->back();
    })->name('activate');

    Route::get('reports', [App\Http\Controllers\ReportController::class, 'index'])->name('reports');

    Route::get('repayments', [App\Http\Controllers\LoanController::class, 'allRepayments'])->name('repayments');

    Route::post('reports', [App\Http\Controllers\ReportController::class, 'filter'])->name('reports.filter');

    Route::resource('accounts', 'App\Http\Controllers\AccountController');

    Route::post('deposits/approve-selected', [App\Http\Controllers\DepositController::class, 'approveSelected'])->name('approve-selected-deposits');
    Route::get('deposits/remove-deposit/{deposit}', [App\Http\Controllers\DepositController::class, 'destroy'])->name('remove-deposit');
    Route::get('deposits/approve-deposit/{deposit}', [App\Http\Controllers\DepositController::class, 'approve'])->name('approve-deposit');
    Route::get('deposits/approve-all', [App\Http\Controllers\DepositController::class, 'approveAll'])->name('approve-all-deposits');

    Route::get('deposit-approvals', [App\Http\Controllers\DepositController::class, 'approvals'])->name('approvals');

    Route::get('withdrawal-approvals', [App\Http\Controllers\WithdrawalController::class, 'approvals'])->name('withdrawal.approvals');

    Route::get('loan-approvals', [App\Http\Controllers\LoanController::class, 'approvals'])->name('loans.approvals');

    Route::get('loans/approve-all', [App\Http\Controllers\LoanController::class, 'approveAll'])->name('approve-all-loans');

    Route::get('loan/remove-loan/{loan}', [App\Http\Controllers\LoanController::class, 'destroy'])->name('remove-loan');

    Route::get('loan/approve-loan/{loan}', [App\Http\Controllers\LoanController::class, 'approve'])->name('approve-loan');

    Route::get('passbook-fees-summary', [App\Http\Controllers\CommissionController::class, 'passbookFeesSummary'])->name('passbook-fees-summary');

    Route::get('passbook-fees', [App\Http\Controllers\CommissionController::class, 'passbookFees'])->name('passbook-fees');

    Route::post('passbook-fees', [App\Http\Controllers\CommissionController::class, 'passbookFeesStore'])->name('passbook-fees.store');

    Route::resource('deposits', 'App\Http\Controllers\DepositController');

    Route::resource('users', 'App\Http\Controllers\UserController');

    Route::post('withdrawals/approve-selected', [App\Http\Controllers\WithdrawalController::class, 'approveSelected'])->name('approve-selected-withdrawals');

    Route::get('withdrawals/approve-withdrawal/{withdrawal}', [App\Http\Controllers\WithdrawalController::class, 'approve'])->name('approve-withdrawal');

    Route::get('withdrawals/remove-withdrawal/{withdrawal}', [App\Http\Controllers\WithdrawalController::class, 'remove'])->name('remove-withdrawal');

    Route::get('withdrawals/approve-all', [App\Http\Controllers\WithdrawalController::class, 'approveAll'])->name('approve-all-withdrawals');

    Route::resource('withdrawals', 'App\Http\Controllers\WithdrawalController');

    Route::get('loan-repayments/remove/{loanRepayment}', [App\Http\Controllers\LoanRepaymentController::class, 'destroy'])->name('remove-repayment');

    Route::get('loan-repayments/approve/{loanRepayment}', [App\Http\Controllers\LoanRepaymentController::class, 'approve'])->name('approve-repayment');

    Route::resource('loan-repayments', 'App\Http\Controllers\LoanRepaymentController');

    Route::resource('loans', 'App\Http\Controllers\LoanController');

    Route::resource('commissions', 'App\Http\Controllers\CommissionController');

    Route::resource('bank-accounts', 'App\Http\Controllers\BankAccountController');

    Route::resource('bank-deposits', 'App\Http\Controllers\BankDepositController');

    Route::resource('bank-withdrawals', 'App\Http\Controllers\BankWithdrawalController');

    Route::resource('sms', 'App\Http\Controllers\SmsController');

    Route::get('get-data/{account}', [App\Http\Controllers\UtilityController::class, 'getData']);
});

Route::get('monthly-sms-charge', [App\Http\Controllers\CommissionController::class, 'monthlySmsCharge']);
