@extends('layouts.auth')

@section('title', 'Login')

@section('content')
<div class="auth-wrapper d-flex no-block justify-content-center align-items-center" style="background:url(https://images.unsplash.com/photo-1590142419789-e7c4d8b0e565?ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&ixlib=rb-1.2.1&auto=format&fit=crop&w=1267&q=80) no-repeat center center; background-size: cover;">
    <div class="auth-box p-4 bg-white rounded">
        <div id="loginform">
            <div class="logo text-center">
                <h2 class="box-title mb-3"><b>Dougy Star Ventures</b></h2>
                <h2 class="box-title mb-3"><b>Sign In</b></h2>
            </div>
            <div class="row">
                <div class="col-12">
                    <form class="form-horizontal mt-3 form-material" method="POST" action="{{ route('login') }}">
                        @csrf
                        @method('POST')
                        <div class="form-group row">
                            <label for="email" class="col-md-12 col-form-label text-md-left">{{ __('E-Mail Address') }}</label>

                            <div class="col-md-12">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-12 col-form-label text-md-left">{{ __('Password') }}</label>

                            <div class="col-md-12">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="d-flex">
                                <div class="checkbox checkbox-info pt-0">
                                    <input id="checkbox-signup" type="checkbox" name="remember" class="material-inputs chk-col-indigo">
                                    <label for="checkbox-signup"> Remember me </label>
                                </div>
                                <div class="ml-auto">
                                    {{--  <a href="{{ route('password.request') }}" id="to-recover" class="text-muted float-right"><i class="fa fa-lock mr-1"></i> Forgot pwd?</a>  --}}
                                </div>
                            </div>
                        </div>
                        <div class="form-group text-center mt-4">
                            <div class="col-xs-12">
                                <button class="btn btn-success btn-lg btn-block text-uppercase waves-effect waves-light" type="submit">Log In</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
