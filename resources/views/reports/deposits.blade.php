@extends('layouts.app')

@section('title', 'Deposits Report ')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <h3 class="card-title"> @yield('title') <span class="badge badge-pill badge-success">{{ $deposits->count() }}</span></h3>
                    </div>
                </div><hr>
                <div class="table-responsive">
                    <table id="file_export" class="file_export table table-striped table-bordered display">
                        <thead>
                            <tr>
                                <th class="text-center">S/N</th>
                                <th>Account Number</th>
                                <th>Account Holder</th>
                                <th>Ref</th>
                                <th>Amount</th>
                                <th>Agent</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($deposits as $deposit)
                            <tr>
                                <td class="text-center">{{ $loop->iteration }}</td>
                                <td>
                                    <img src="{{ $deposit->account->profile_photo??"" }}" class="rounded-circle" width="50" height="50" />
                                    {{ $deposit->account->account_number??"" }}
                                </td>
                                <td>{{ $deposit->account->full_name??"" }}</td>
                                <td>Deposits</td>
                                <td class="text-success"><b>GHS {{ number_format($deposit->amount,2) }}</b></td>
                                <td>{{ $deposit->agent->name }}</td>
                                <td>{{ $deposit->date }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th class="text-center">S/N</th>
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
