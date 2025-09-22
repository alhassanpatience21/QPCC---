@extends('layouts.app')

@section('title', 'Commissions')

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
                                <th class="text-dark font-weight-bold">Account Holder</th>
                                <th class="text-dark font-weight-bold">Account Number</th>
                                <th class="text-dark font-weight-bold">Amount</th>
                                <th class="text-dark font-weight-bold">Source</th>
                                <th class="text-dark font-weight-bold">Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($commissions as $commission)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <img src="{{ $commission->account->profile_photo }}" alt="avatar" class="rounded-circle ml-2" width="50" height="50">
                                        <div class="ml-2">
                                            <div class="user-meta-info">
                                                <h5 class="user-name mb-0" data-name="{{ $commission->account->full_name }}">{{ $commission->account->full_name }}</h5>
                                                <span class="user-work text-muted" data-occupation="{{ $commission->account->phone_number_one }}">{{ $commission->account->phone_number_one }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td>{{ $commission->account->account_number }}</td>
                                <td>{{ moneyFormat($commission->amount) }}</td>
                                <td>{{ ucfirst($commission->source) }}</td>
                                <td>{{ $commission->date }}</td>
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
