@extends('layouts.app')

@section('title', 'Loan Repayment Details')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h3 class="card-title"> @yield('title')</h3><hr>
                <div class="table-responsive">
                    <table class="table product-overview v-middle file_export">
                        <thead>
                            <tr>
                                <th class="border-0">#</th>
                                <th>Amount Paid</th>
                                <th>Repayment Date</th>
                                <th>Week Balance</th>
                                <th>Ending Balance</th>
                                <th>Status</th>
                                <th>Agent</th>
                                @can('approve', 'App\Models\User')
                                <th class="border-0"></th>
                                @endcan
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($loanRepayments as $loanRepayment)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
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
                                <td>
                                    @if (!$loanRepayment->approval_status)
                                        @can('approve', 'App\Models\User')
                                        <a href="{{ route('approve-repayment', $loanRepayment) }}" class="btn btn-sm btn-light-primary text-primary">
                                            Approve
                                        </a><br>
                                        <a href="{{ route('remove-repayment', $loanRepayment) }}" class="btn btn-sm btn-light-danger text-danger">
                                            Remove
                                        </a>
                                        @endcan
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
