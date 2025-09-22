@extends('layouts.app')

@php
    $accountNumber = request()->get('account');
@endphp

@section('title', 'Bank Withdrawals')

@section('content')
<div class="container mx-auto row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h3 class="card-title"> @yield('title')</h3>
            </div>
            <hr>
            <form class="form-horizontal" action="{{ route('bank-withdrawals.store') }}" method="POST">
                @method('POST')
                @csrf
                <div class="card-body">
                    <div class="form-group row">
                        <label for="fname" class="col-sm-3 text-right control-label col-form-label">Date of Withdrawals</label>
                        <div class="col-sm-7">
                            <input type="date" class="form-control @error('date_of_withdrawal') is-invalid @enderror" id="date_of_withdrawal" name="date_of_withdrawal" value="{{ old('date_of_withdrawal', date('Y-m-d')) }}">
                            @error('date_of_withdrawal')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="lname" class="col-sm-3 text-right control-label col-form-label">Account Number</label>
                        <div class="col-sm-7">
                            <select name="account_number" id="account_number" style="width: 100%; height:36px;" class="form-control custom-select select2 @error('account_number') is-invalid @enderror" id="account_number">
                                <option value=""></option>
                                @foreach ($accounts as $account)
                                    <option value="{{ $account->account_number }}" {{ $accountNumber == $account->account_number?'selected':'' }}><b>{{ $account->account_number }}</b> - {{ $account->account_name }}</option>
                                @endforeach
                            </select>
                            @error('account_number')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="lname" class="col-sm-3 text-right control-label col-form-label">Amount GHS</label>
                        <div class="col-sm-7">
                            <input type="text" id="amount" class="form-control @error('amount') is-invalid @enderror" name="amount" value="{{ old('amount',0) }}">
                            @error('amount')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="lname" class="col-sm-3 text-right control-label col-form-label">Cheque Number</label>
                        <div class="col-sm-7">
                            <input type="text" id="cheque_number" class="form-control @error('cheque_number') is-invalid @enderror" id="cheque_number" name="cheque_number" value="{{ old('cheque_number') }}">
                            @error('cheque_number')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                </div>
                <hr>
                <div class="card-body">
                    <div class="form-group mb-0 text-center">
                        <button type="submit" class="btn btn-info waves-effect waves-light">Make Deposit</button>
                        <a href="{{ route('bank-accounts.show', $accountNumber) }}" class="btn btn-dark waves-effect waves-light">Cancel</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
