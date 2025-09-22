@extends('layouts.app')

@section('title', 'Withdrawals Report')

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
                                <th>Ref</th>
                                <th>Amount</th>
                                <th>Agent</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($withdrawals as $withdrawal)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td><img src="{{ $withdrawal->account->profile_photo??"" }}" class="rounded-circle" width="50" height="50" /></td>
                                <td>{{ $withdrawal->account->account_number??"" }}</td>
                                <td>{{ $withdrawal->account->full_name??"" }}</td>
                                <td>Withdrawal</td>
                                <td>GHS {{ number_format($withdrawal->amount, 2) }}</td>
                                <td>{{ $withdrawal->agent->name }}</td>
                                <td>{{ $withdrawal->date }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>S/N</th>
                                <th>Photo</th>
                                <th>Account Number</th>
                                <th>Account Holder</th>
                                <th>Ref</th>
                                <th>Amount</th>
                                <th>Agent</th>
                                <th>Date</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
