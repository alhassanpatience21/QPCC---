@extends('layouts.app')

@section('title', 'Accounts')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="card-title">
                    <div class="row">
                        <div class="col">
                            @yield('title')
                        </div>

                        <div class="col text-right">
                            <a href="{{ route('accounts.create') }}" class="btn btn-success"> Create Account</a>
                        </div>
                    </div>
                </div><hr>
                <div class="table-responsive">
                    <table id="file_export" class="file_export table table-striped table-bordered display">
                        <thead>
                            <tr>
                                <th class="text-center">S/N</th>
                                <th class="text-dark font-weight-bold">Account Holder</th>
                                <th class="text-dark font-weight-bold">Account Number</th>
                                <th class="text-dark font-weight-bold">Base Amount</th>
                                <th class="text-dark font-weight-bold text-center">Account Type</th>
                                <th class="text-dark font-weight-bold">Passbook Fee</th>
                                <th class="text-dark font-weight-bold">Reg. Officer</th>
                                <th class="text-dark font-weight-bold">Status</th>
                                <th class="text-dark font-weight-bold  text-center"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($accounts as $account)
                            <tr>
                                <td class="text-center">{{ $loop->iteration }}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <img src="{{ $account->profile_photo }}" alt="avatar" class="rounded-circle ml-2" width="50" height="50">
                                        <div class="ml-2">
                                            <div class="user-meta-info">
                                                <h5 class="user-name mb-0" data-name="{{ $account->full_name }}">{{ $account->full_name }}</h5>
                                                <small>{{ $account->phone_number_one }}</small>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td>{{ $account->account_number }}</td>
                                <td>{{ $account->amount }}</td>
                                <td class="text-center">
                                    @if ($account->savings_account)
                                    <span class="badge badge-pill badge-secondary">Savings</span>
                                    @endif

                                    @if ($account->susu_account)
                                        <span class="badge badge-pill badge-info">Susu</span>
                                    @endif
                                </td>
                                <td>
                                    <b>
                                        @if ($account->passbook_status)
                                        <span style="color: green"><i class="fa fa-check-circle"></i> Paid</span>
                                        @else
                                        <span class="text-danger"><i class="fa fa-info-circle"></i> {{ moneyFormat($account->passbook_balance) }}</span>
                                        @endif
                                    </b>
                                </td>
                                <td>{{ $account->user->name??'' }}</td>
                                <td><span style="color: green"> Active</span></td>
                                <td class="text-center">
                                    <a href="{{ route('accounts.show', $account) }}" class="btn btn-success">Profile</a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th class="text-center">S/N</th>
                                <th class="text-dark font-weight-bold">Account Holder</th>
                                <th class="text-dark font-weight-bold">Account Number</th>
                                <th class="text-dark font-weight-bold">Base Amount</th>
                                <th class="text-dark font-weight-bold text-center">Account Type</th>
                                <th class="text-dark font-weight-bold">Passbook Fee</th>
                                <th class="text-dark font-weight-bold">Reg. Officer</th>
                                <th class="text-dark font-weight-bold">Status</th>
                                <th class="text-dark font-weight-bold  text-center"></th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
