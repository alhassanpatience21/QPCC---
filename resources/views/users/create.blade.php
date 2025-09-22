@extends('layouts.app')

@section('title', 'Create user Account')

@section('content')
<div class="container mx-auto row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h3 class="card-title"> @yield('title')</h3>
            </div>
            <hr>
            <form class="form-horizontal" action="{{ route('users.store') }}" method="POST">
                @method('POST')
                @csrf
                <div class="card-body">
                    <div class="form-group row">
                        <label for="lname" class="col-sm-3 text-right control-label col-form-label">Full Name</label>
                        <div class="col-sm-7">
                            <input type="text" id="name" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}">
                            @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="lname" class="col-sm-3 text-right control-label col-form-label">Email</label>
                        <div class="col-sm-7">
                            <input type="text" id="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}">
                            @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="lname" class="col-sm-3 text-right control-label col-form-label">Phone Number</label>
                        <div class="col-sm-7">
                            <input type="text" id="phone_number" class="form-control @error('phone_number') is-invalid @enderror" id="phone_number" name="phone_number" value="{{ old('phone_number') }}">
                            @error('phone_number')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="lname" class="col-sm-3 text-right control-label col-form-label">Password</label>
                        <div class="col-sm-7">
                            <input type="password" id="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" value="{{ old('password') }}">
                            @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="lname" class="col-sm-3 text-right control-label col-form-label">Account Type</label>
                        <div class="col-sm-7">
                            <select name="account_type" id="account_type" style="width: 100%; height:36px;" class="form-control custom-select select2 @error('account_type') is-invalid @enderror" >
                                <option value="Agent">Agent</option>
                                <option value="Secretary">Secretary</option>
                                <option value="Administrator">Administrator</option>
                            </select>
                            @error('account_type')
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
                        <button type="submit" class="btn btn-info waves-effect waves-light">Create User Account</button>
                        <a href="{{ route('users.index') }}" class="btn btn-dark waves-effect waves-light">Cancel</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
