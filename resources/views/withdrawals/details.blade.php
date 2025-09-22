@extends('layouts.app')

@section('title', 'Withdrawals')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h3 class="card-title"> @yield('title')</h3><hr>
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
                            @foreach ($withdrawals as $withdrawal)
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
                                    <span class="px-2 py-1 badge bg-warning text-white font-weight-100">Pending</span>
                                    @endif
                                </td>
                                <td>{{ $withdrawal->date }}</td>

                                <td>
                                    {{--  <a href="{{ route('withdrawals.show', $withdrawal) }}" class="btn btn-success">Receipt</a>  --}}

                                    @if (!$withdrawal->approval_status)
                                        @can('approve', 'App\Models\User')
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
            </div>
        </div>
    </div>
</div>
@endsection
