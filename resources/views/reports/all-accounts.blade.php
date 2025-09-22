@extends('layouts.app')

@section('title', 'Accounts Report')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table id="file_export" class="file_export table table-striped table-bordered display">
                        <thead>
                            <tr>
                                <th class="text-center">S/N</th>
                                <th class="text-dark font-weight-bold">Account Holder</th>
                                <th class="text-dark font-weight-bold">Account Number</th>
                                <th class="text-dark font-weight-bold">Deposits</th>
                                <th class="text-dark font-weight-bold">Withdrawals</th>
                                <th class="text-dark font-weight-bold">Commissions</th>
                                <th class="text-dark font-weight-bold">Total Balance</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($accounts as $account)
                            <tr>
                                <td class="text-center">{{ $loop->iteration }}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <img src="{{ $account->profile_photo }}" alt="avatar" class="rounded-circle ml-2" width="50" height="50">
                                        <div class="ml-2">
                                            <div class="user-meta-info">
                                                <h5 class="user-name mb-0" data-name="{{ $account->full_name }}">{{ $account->full_name }}</h5>
                                                <small>{{ $account->phone_number_one }}</small>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td>{{ $account->account_number }}</td>
                                <td>{{ number_format( $account->deposits->whereBetween('date_of_deposit', [$from, $to])->sum('amount')) }}</td>
                                <td>{{ number_format($account->withdrawals->whereBetween('date_of_withdrawal', [$from, $to])->sum('amount'), 2) }}</td>
                                <td>{{ number_format($account->commissions->whereBetween('transaction_date', [$from, $to])->sum('amount'),2) }}</td>
                                <td>{{ number_format($account->actual_balance, 2) }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th class="text-center">S/N</th>
                                <th class="text-dark font-weight-bold">Account Holder</th>
                                <th class="text-dark font-weight-bold">Account Number</th>
                                <th class="text-dark font-weight-bold">Deposits</th>
                                <th class="text-dark font-weight-bold">Withdrawals</th>
                                <th class="text-dark font-weight-bold">Commissions</th>
                                <th class="text-dark font-weight-bold">Total Balance</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
