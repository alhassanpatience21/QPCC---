@extends('layouts.app')

@section('title', 'Loans Report')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h3 class="card-title"> @yield('title')</h3><hr>
                <div class="table-responsive">
                    <table id="file_export" class="file_export table table-striped table-bordered display">
                        <thead>
                            <tr >
                                <th class="text-center">S/N</th>
                                <th>Account</th>
                                <th>Principal</th>
                                <th>Interest</th>
                                <th>Loan Amount</th>
                                <th>Amt Paid</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($loans as $loan)
                            <tr>
                                <td class="text-center">{{ $loop->iteration }}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <img src="{{ $loan->account->profile_photo }}" alt="avatar" class="rounded-circle ml-2" width="50" height="50">
                                        <div class="ml-2">
                                            <div class="user-meta-info">
                                                <h5 class="user-name mb-0" data-name="{{ $loan->account->full_name }}">{{ $loan->account->full_name }}</h5>
                                                <small>{{ $loan->account_number }}</small>
                                                @if ($loan->account->savings_account)
                                                <span class="badge badge-pill badge-secondary">Savings</span>
                                                @endif

                                                @if ($loan->account->susu_account)
                                                    <span class="badge badge-pill badge-info">Susu</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-success"><b>GHS {{ number_format($loan->principal_amount,2) }}</b></td>
                                <td class="text-success"><b>GHS {{ number_format($loan->interest,2) }}</b></td>
                                <td class="text-success"><b>GHS {{ number_format($loan->loan_amount,2) }}</b></td>
                                <td class="text-success"><b>GHS {{ moneyFormat($loan->loanRepayments()->where('approval_status', 1)->sum('amount')) }}</b></td>
                                
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th class="text-center">S/N</th>
                                <th>Account</th>
                                <th>Principal</th>
                                <th>Interest</th>
                                <th>Loan Amount</th>
                                <th>Amt Paid</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
