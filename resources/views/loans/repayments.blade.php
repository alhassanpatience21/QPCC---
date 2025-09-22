@extends('layouts.app')

@section('title', 'Repayments')

@section('content')
<div class="row">
    <div class="col-lg-4">
        <div class="card bg-info text-white">
            <div class="card-body">
                <div class="d-flex no-block align-items-center">
                    <a href="JavaScript: void(0);"><i class="display-6 icon  icon-check text-white" title="ETH"></i></a>
                    <div class="ml-3 mt-2">
                        <h4 class="font-weight-medium mb-0 text-white">Approved</h4>
                        <h5 class="text-white">{{ moneyFormat($loanRepayments->where('approval_status', 1)->sum('amount'))}}</h5>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card bg-danger text-white">
            <div class="card-body">
                <div class="d-flex no-block align-items-center">
                    <a href="JavaScript: void(0);"><i class="display-6 icon icon-info text-white" title="LTC"></i></a>
                    <div class="ml-3 mt-2">
                        <h4 class="font-weight-medium mb-0 text-white">Pending</h4>
                        <h5 class="text-white">{{ moneyFormat($loanRepayments->where('approval_status', 0)->sum('amount'))}}</h5>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card bg-warning text-white">
            <div class="card-body">
                <div class="d-flex no-block align-items-center">
                    <a href="JavaScript: void(0);"><i class="display-6 icon icon-badge text-white" title="BTC"></i></a>
                    <div class="ml-3 mt-2">
                        <h4 class="font-weight-medium mb-0 text-white">Grand Total</h4>
                        <h5 class="text-white">{{ moneyFormat($loanRepayments->sum('amount'))}}</h5>
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
                    <div class="col">
                        <h3 class="card-title"> @yield('title')</h3>
                    </div>
                    <div class="col text-right">
                        <a href="{{ route('loan-repayments.create') }}" class="btn btn-success">Make Repayment</a>
                    </div>
                </div>
                <hr>
               @if (auth()->user()->role == 'Agent')
                <div class="table-responsive">
                    <table id="file_export" class="file_export table table-striped table-bordered display">
                        <thead>
                            <tr>
                                <th>S/N</th>
                                <th>Photo</th>
                                <th>Account Number</th>
                                <th>Account Holder</th>
                                <th>Amount</th>
                                <th>Recorded By</th>
                                <th>Approval Status</th>
                                <th>Date</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($loanRepayments as $withdrawal)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td><img src="{{ $withdrawal->account->profile_photo??"" }}" class="rounded-circle" width="50" height="50" /></td>
                                <td>{{ $withdrawal->account->account_number??"" }}</td>
                                <td>{{ $withdrawal->account->full_name??"" }}</td>
                                <td>GHS {{ number_format($withdrawal->amount, 2) }}</td>
                                <td>{{ $withdrawal->agent->name }}</td>
                                <td>
                                    @if ($withdrawal->approval_status)
                                    <span class="px-2 py-1 badge bg-success text-white font-weight-100">Approved</span>
                                    @else
                                    <span class="px-2 py-1 badge bg-warning text-white font-weight-100">Pending Approval</span>
                                    @endif
                                </td>
                                <td>{{ $withdrawal->date }}</td>

                                <td>
                                    @if (!$withdrawal->approval_status)
                                        @can('view-any', 'App\Models\User')
                                            <a href="{{ route('approve-withdrawal', $withdrawal) }}" class="btn btn-sm btn-primary text-white">Approve</a>
                                        @endcan
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>S/N</th>
                                <th>Photo</th>
                                <th>Account Number</th>
                                <th>Account Holder</th>
                                <th>Amount</th>
                                <th>Recorded By</th>
                                <th>Approval Status</th>
                                <th>Date</th>
                                <th></th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                @else
                <div class="table-responsive">
                    <table id="file_export" class="file_export table table-striped table-bordered display">
                        <thead>
                            <tr>
                                <th>S/N</th>
                                <th>Date</th>
                                <th>Total Repayments</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($loanRepayments->unique('repayment_date') as $loanRepayment)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $loanRepayment->date }}</td>
                                <td>{{ moneyFormat($loanRepayments->where('repayment_date', $loanRepayment->repayment_date)->sum('amount'))}}</td>
                                <td class="text-right">
                                    <a href="{{ route('repayments', 'date='.$loanRepayment->repayment_date) }}" class="btn btn-success">View Details</a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>S/N</th>
                                <th>Date</th>
                                <th>Total Repayments</th>
                                <th></th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
