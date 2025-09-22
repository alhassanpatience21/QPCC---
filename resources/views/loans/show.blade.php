@extends('layouts.app')

@section('title', 'Loan history for '. $loan->account->full_name)

@section('content')
<div class="row">
    <div class="col-lg-3 col-md-6">
        <div class="card border-right border-dark">
            <div class="card-body">
                <div class="d-flex no-block align-items-center">
                    <div>
                        <span class="text-dark display-6"><i class="ti-layout-slider-alt"></i></span>
                    </div>
                    <div class="ml-auto">
                        <h2>{{ moneyFormat($loan->loan_amount)}}</h2>
                        <h6 class="text-dark">Loan Amount</h6>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6">
        <div class="card border-right border-warning">
            <div class="card-body">
                <div class="d-flex no-block align-items-center">
                    <div>
                        <span class="text-warning display-6"><i class="ti-cup"></i></span>
                    </div>
                    <div class="ml-auto">
                        <h2>{{ moneyFormat($loan->loanRepayments->where('approval_status', 1)->sum('amount')) }}</h2>
                        <h6 class="text-warning">Amount Paid</h6>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6">
        <div class="card border-right border-info">
            <div class="card-body">
                <div class="d-flex no-block align-items-center">
                    <div>
                        <span class="text-info display-6"><i class="ti-wallet"></i></span>
                    </div>
                    <div class="ml-auto">
                        <h2>{{ moneyFormat($loan->loan_amount - $loan->loanRepayments->where('approval_status', 1)->sum('amount'))}}</h2>
                        <h6 class="text-info">Outstanding Balance</h6>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6">
        <div class="card border-right border-success">
            <div class="card-body">
                <div class="d-flex no-block align-items-center">
                    <div>
                        <span class="text-success display-6"><i class="ti-calendar"></i></span>
                    </div>
                    <div class="ml-auto">
                        <h2>{{ $loan->days_left }}</h2>
                        <h6 class="text-success">Days Left</h6>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col"><h3 class="card-title"> @yield('title')</h3></div>
                    <div class="col text-right">
                        <a href="{{ route('loan-repayments.create') }}" class="btn btn-success">Add Repayment</a>
                    </div>
                </div><hr>
                <div class="table-responsive">
                    <table id="file_export" class="file_export table table-striped table-bordered display">
                        <thead>
                            <tr>
                                <th class="text-center">S/N</th>
                                <th>Amount Paid</th>
                                <th>Repayment Date</th>
                                <th>Week Balance</th>
                                <th>Ending Balance</th>
                                <th>Status</th>
                                <th>Agent</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($loan->loanRepayments as $loanRepayment)
                            <tr>
                                <td class="text-center">{{ $loop->iteration }}</td>
                                <td>{{ moneyFormat($loanRepayment->amount) }}</td>
                                <td>{{ $loanRepayment->date }}</td>
                                <td>{{ moneyFormat($loanRepayment->week_ending_balance) }}</td>
                                <td>{{ moneyFormat($loanRepayment->ending_balance) }}</td>
                                <td>
                                    @if ($loanRepayment->approval_status)
                                    <span class="px-2 py-1 badge bg-success text-white font-weight-100">Approved</span>
                                    @else
                                    <span class="px-2 py-1 badge bg-warning text-white font-weight-100">Pending Approval</span>
                                    @endif
                                </td>
                                <td>{{ $loanRepayment->agent->name }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th class="text-center">S/N</th>
                                <th>Amount Paid</th>
                                <th>Repayment Date</th>
                                <th>Week Balance</th>
                                <th>Ending Balance</th>
                                <th>Status</th>
                                <th>Agent</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
