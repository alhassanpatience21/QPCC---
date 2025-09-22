@extends('layouts.app')

@section('title', 'Outstanding Loan Repayment Approvals')

@section('content')
    @foreach ($loans as $loan)
        @if ($loan->loanRepayments->where('approval_status', 0)->isNotEmpty())
        <div class="card w-100">
            <form action="{{ route('approve-selected-deposits') }}" method="post">
                @csrf
                <div class="card-header bg-white">
                    <h3 class="card-title mb-0">Pending Repayment Approval</h3>
                    <h4 class="mb-0"><img src="{{ $loan->account->profile_photo }}" alt="{{ $loan->account->full_name }}" width="50" height="50" class="rounded-circle"> {{ $loan->account->full_name }} - {{ $loan->account->account_number }}</h4>
                    <hr>
                </div>
                <div class="card-body collapse show">
                    <div class="table-responsive no-wrap">
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
                                @foreach ($loan->loanRepayments->where('approval_status', 0) as $loanRepayment)
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
                                        @can('approve', 'App\Models\User')
                                        <a href="{{ route('approve-repayment', $loanRepayment) }}" class="btn btn-sm btn-light-primary text-primary">
                                            Approve
                                        </a><br>
                                        <a href="{{ route('remove-repayment', $loanRepayment) }}" class="btn btn-sm btn-light-danger text-danger">
                                            Remove
                                        </a>
                                        @endcan
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </form>
        </div>
        @endif
    @endforeach
@endsection
