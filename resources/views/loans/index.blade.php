@extends('layouts.app')

@section('title', 'Loans')

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
                        <h2>{{ moneyFormat($loans->sum('principal_amount') + $loans->sum('interest'))}}</h2>
                        <h6 class="text-dark">Disbursed Loans</h6>
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
                        <span class="text-info display-6"><i class="ti-pie-chart"></i></span>
                    </div>
                    <div class="ml-auto">
                        @php
                        $total = 0;
                        foreach($loans as $loan){
                            $total += $loan->loanRepayments->where('approval_status', 1)->sum('amount');
                        }
                        @endphp
                        <h2>{{ moneyFormat(($loans->sum('principal_amount') + $loans->sum('interest'))-$total)}}</h2>
                        <h6 class="text-info">Outstanding Balance</h6>
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
                        <span class="text-warning display-6"><i class="ti-panel"></i></span>
                    </div>
                    <div class="ml-auto">
                        <h2>{{ $loans->where('status', 1)->count() }}</h2>
                        <h6 class="text-warning">Completed Loans</h6>
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
                        <span class="text-success display-6"><i class="ti-layers-alt"></i></span>
                    </div>
                    <div class="ml-auto">
                        <h2>{{ $loans->where('status', 0)->count() }}</h2>
                        <h6 class="text-success">Outstanding Loans</h6>
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
                        @can('view-any', 'App\Models\User')
                        <a href="{{ route('loans.create') }}" class="btn btn-success">Disburse Loan</a>
                        @endcan
                    </div>
                </div><hr>
                <div class="table-responsive">
                    <table id="file_export" class="file_export table table-striped table-bordered display">
                        <thead>
                            <tr >
                                <th class="text-center">S/N</th>
                                <th>Account</th>
                                <th>Principal</th>
                                <th>Interest</th>
                                <th>Duration</th>
                                <th>Days left</th>
                                <th>Amt Paid</th>
                                <th>Status</th>
                                <th></th>
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
                                <td>{{ $loan->duration }}</td>
                                <td>{{ $loan->days_left}} Days</td>
                                <td class="text-success"><b>GHS {{ moneyFormat($loan->loanRepayments()->where('approval_status', 1)->sum('amount')) }}</b></td>
                                <td>
                                    @if ($loan->status)
                                    <span class="badge badge-pill badge-success">Expired</span>
                                    @endif

                                    @if (!$loan->status)
                                    <span class="badge badge-pill badge-warning">Running</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <a href="{{ route('loans.show', $loan) }}" class="btn btn-primary">More</a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th class="text-center">S/N</th>
                                <th>Account</th>
                                <th>Principal</th>
                                <th>Interest</th>
                                <th>Duration</th>
                                <th>Days left</th>
                                <th>Amt Paid</th>
                                <th>Status</th>
                                <th></th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
