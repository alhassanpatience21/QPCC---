@extends('layouts.app')

@section('title', 'Create Bank Account')

@section('content')
<div class="container mx-auto row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h3 class="card-title"> @yield('title')</h3>
            </div>
            <hr>
            <form class="form-horizontal" action="{{ route('bank-accounts.store') }}" method="POST">
                @method('POST')
                @csrf
                <div class="card-body">
                    <div class="form-group row">
                        <label for="fname" class="col-sm-3 text-right control-label col-form-label">Account Name</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control @error('account_name') is-invalid @enderror" id="account_name" name="account_name" value="{{ old('account_name') }}">
                            @error('account_name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="lname" class="col-sm-3 text-right control-label col-form-label">Account Description</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control @error('account_description') is-invalid @enderror" id="account_description" name="account_description" value="{{ old('account_description') }}">
                            @error('account_description')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="lname" class="col-sm-3 text-right control-label col-form-label">Account Number</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control @error('account_number') is-invalid @enderror" id="account_number" name="account_number" value="{{ old('account_number') }}">
                                @error('account_number')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="email1" class="col-sm-3 text-right control-label col-form-label">Branch</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control @error('account_branch') is-invalid @enderror" id="account_branch" name="account_branch" value="{{ old('account_branch') }}">
                            @error('account_branch')
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
                        <button type="submit" class="btn btn-info waves-effect waves-light">Create Account</button>
                        <a href="{{ route('bank-accounts.index') }}" class="btn btn-dark waves-effect waves-light">Cancel</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

