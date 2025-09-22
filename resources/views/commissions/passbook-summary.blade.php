@extends('layouts.app')

@section('title', 'Passbook Fee Summary')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col"><h3 class="card-title"> @yield('title')</h3></div>
                </div><hr>
                @if (isset(request()->date))
                <div class="table-responsive">
                    <table id="file_export" class="file_export table table-striped table-bordered display">
                        <thead>
                            <tr >
                                <th class="text-center">S/N</th>
                                <th>Account</th>
                                <th>Amount</th>
                                <th>Agent</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($fees as $fee)
                            <tr>
                                <td class="text-center">{{ $loop->iteration }}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <img src="{{ $fee->account->profile_photo }}" alt="avatar" class="rounded-circle ml-2" width="50" height="50">
                                        <div class="ml-2">
                                            <div class="user-meta-info">
                                                <h5 class="user-name mb-0" data-name="{{ $fee->account->full_name }}">{{ $fee->account->full_name }}</h5>
                                                <small>{{ $fee->account_number }}</small>
                                                @if ($fee->account->savings_account)
                                                <span class="badge badge-pill badge-secondary">Savings</span>
                                                @endif

                                                @if ($fee->account->susu_account)
                                                    <span class="badge badge-pill badge-info">Susu</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-success"><b>GHS {{ number_format($fee->amount,2) }}</b></td>
                                <td>{{ $fee->user->name??'' }}</td>
                                <td>{{ $fee->date }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th class="text-center">S/N</th>
                                <th>Account</th>
                                <th>Amount</th>
                                <th>Agent</th>
                                <th>Date</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                @else
                <div class="table-responsive">
                    <table id="file_export" class="file_export table table-striped table-bordered display">
                        <thead>
                            <tr>
                                <th class="text-center">S/N</th>
                                <th>Date</th>
                                <th>Total </th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($fees->unique('transaction_date') as $fee)
                            <tr>
                                <td class="text-center">{{ $loop->iteration }}</td>
                                <td>{{ $fee->date }}</td>
                                <td>{{ moneyFormat($fees->where('transaction_date', $fee->transaction_date)->sum('amount'))}}</td>
                                <td class="text-right">
                                    <a href="{{ route('passbook-fees-summary', 'date='.$fee->transaction_date) }}" class="btn btn-success">History</a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th class="text-center">S/N</th>
                                <th>Date</th>
                                <th>Total</th>
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
