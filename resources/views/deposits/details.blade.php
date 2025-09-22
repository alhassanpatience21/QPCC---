@extends('layouts.app')

@section('title', 'Deposits')

@php
    $date = request()->get('date');
@endphp

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <h3 class="card-title"> @yield('title')</h3>
                    </div>
                    <div class="col-md-6 text-right">
                        <button type="button" class="btn btn-success" data-toggle="modal" data-target="#exampleModalCenter">
                        View Agent Summary
                        </button>
                    </div>
                </div><hr>
                <div class="table-responsive">
                    <table id="file_export" class="file_export table table-striped table-bordered display">
                        <thead>
                            <tr>
                                <th>S/N</th>
                                <th>Photo</th>
                                <th>Account Number</th>
                                <th>Account Holder</th>
                                <th>Amount</th>
                                <th>Agent</th>
                                <th>Date</th>
                                <th>Approval Status</th>
                                {{--  <th></th>  --}}
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($deposits as $deposit)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td><img src="{{ $deposit->account->profile_photo??"" }}" class="rounded-circle" width="50" height="50" /></td>
                                <td>{{ $deposit->account->account_number??"" }}</td>
                                <td>{{ $deposit->account->full_name??"" }}</td>
                                <td class="text-success"><b>{{ moneyFormat($deposit->amount) }}</b></td>
                                <td>{{ $deposit->agent->name }}</td>
                                <td>{{ $deposit->date }}</td>
                                <td class="text-center">
                                     @if ($deposit->approval_status)
                                    <span class="px-2 py-1 badge bg-success text-white font-weight-100">Approved</span>
                                    @else
                                    <span class="px-2 py-1 badge bg-warning text-white font-weight-100">Pending</span>
                                    @endif
                                </td>
                                {{--  <td>
                                    <a href="{{ route('deposits.show', $deposit) }}" class="btn btn-success">Receipt</a>
                                </td>  --}}
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
                                <th>Agent</th>
                                <th>Date</th>
                                <th>Approval Status</th>
                                {{--  <th></th>  --}}
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Agent Summary</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
               <div class="table-responsive">
                    <table id="file_export" class="file_export table table-striped table-bordered display">
                        <thead>
                            <tr>
                                <th>S/N</th>
                                <th>Agent</th>
                                <th>Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($agents as $agent)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $agent->name }}</td>
                                <td>GHS {{ number_format($agent->deposits->where('date_of_deposit', $date)->sum('amount'), 2) }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>S/N</th>
                                <th>Agent</th>
                                <th>Amount</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@endsection