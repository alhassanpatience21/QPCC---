@extends('layouts.app')

@section('title', strtoupper($bankAccount->account_name).' ('.$bankAccount->account_number.')')

@section('content')
<div class="row">
    <!-- Column -->
    <div class="col-lg-3 col-md-6">
        <div class="card">
            <div class="card-body">
                <div class="row pt-2 pb-2">
                    <!-- Column -->
                    <div class="col pr-0">
                        <h1 class="font-weight-light">{{ $bankAccount->balance }}</h1>
                        <h6 class="text-muted">Available Balance</h6></div>
                    <!-- Column -->
                    <div class="col text-right align-self-center">
                        <div data-label="20%" class="css-bar mb-0 css-bar-primary css-bar-20"><i class="mdi mdi-account-circle"></i></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Column -->
    <!-- Column -->
    <div class="col-lg-3 col-md-6">
        <div class="card">
            <div class="card-body">
                <div class="row pt-2 pb-2">
                    <!-- Column -->
                    <div class="col pr-0">
                        <h1 class="font-weight-light">{{ $bankAccount->total_deposits }}</h1>
                        <h6 class="text-muted">Total Credits</h6></div>
                    <!-- Column -->
                    <div class="col text-right align-self-center">
                        <div data-label="30%" class="css-bar mb-0 css-bar-danger css-bar-20"><i class="mdi mdi-briefcase-check"></i></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Column -->
    <!-- Column -->
    <div class="col-lg-3 col-md-6">
        <div class="card">
            <div class="card-body">
                <div class="row pt-2 pb-2">
                    <!-- Column -->
                    <div class="col pr-0">
                        <h1 class="font-weight-light">{{ $bankAccount->total_debits }}</h1>
                        <h6 class="text-muted">Total Debits</h6></div>
                    <!-- Column -->
                    <div class="col text-right align-self-center">
                        <div data-label="40%" class="css-bar mb-0 css-bar-warning css-bar-40"><i class="mdi mdi-star-circle"></i></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Column -->
    <!-- Column -->
    <div class="col-lg-3 col-md-6">
        <div class="card">
            <div class="card-body">
                <div class="row pt-2 pb-2">
                    <!-- Column -->
                    <div class="col pr-0">
                        <h1 class="font-weight-light">{{ $bankAccount->trailBalance->count() }}</h1>
                        <h6 class="text-muted">Total Transactions</h6></div>
                    <!-- Column -->
                    <div class="col text-right align-self-center">
                        <div data-label="60%" class="css-bar mb-0 css-bar-info css-bar-60"><i class="mdi mdi-receipt"></i></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Column -->
</div>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <h4 class="card-title">Account Details for @yield('title')</h4>
                    </div>
                    <div class="col-md-6 text-right">
                        <a href="{{ route('bank-deposits.create', 'account='.$bankAccount->account_number) }}" class="btn btn-primary">Make Deposit</a>
                        <a href="{{ route('bank-withdrawals.create', 'account='.$bankAccount->account_number) }}" class="btn btn-success">Make Withdrawal</a>
                    </div>
                </div>
                <hr>
                <div class="table-responsive">
                    <table id="zero_config" class="file_export table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Description</th>
                                <th>Amount</th>
                                <th>Balance</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($bankAccount->trailBalance as $balance)
                            <tr>
                                <td>{{ $balance->transaction_date }}</td>
                                <td>{{ ucfirst($balance->description) }}</td>
                                <td class="{{ $balance->description == 'credit'?'text-success':'text-danger' }}">{{ $balance->description != 'credit'?'-':'' }} {{ number_format($balance->amount, 2) }}</td>
                                <td>{{ number_format($balance->balance, 2) }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>Date</th>
                                <th>Description</th>
                                <th>Amount</th>
                                <th>Balance</th>
                            </tr>.
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
    <script src="{{ asset('js/custom.min.js') }}"></script>
@endsection
