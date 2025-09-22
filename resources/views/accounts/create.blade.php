@extends('layouts.app')

@section('title', 'Create Account')

@section('content')
<div class="container mx-auto row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h3 class="card-title"> @yield('title')</h3>
            </div>
            <hr>
            <form class="form-horizontal" action="{{ route('accounts.store') }}" method="POST" enctype="multipart/form-data">
                @method('POST')
                @csrf
                <div class="card-body">
                    <h4 class="card-title">Personal Information</h4>
                    <div class="form-group row">
                        <label for="fname" class="col-sm-3 text-right control-label col-form-label">First Name</label>
                        <div class="col-sm-7">
                            <input type="text" class="form-control @error('first_name') is-invalid @enderror" id="first_name" name="first_name" value="{{ old('first_name') }}">
                            @error('first_name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="lname" class="col-sm-3 text-right control-label col-form-label">Other Names</label>
                        <div class="col-sm-7">
                            <input type="text" class="form-control @error('other_names') is-invalid @enderror" id="other_names" name="other_names" value="{{ old('other_names') }}">
                            @error('other_names')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="lname" class="col-sm-3 text-right control-label col-form-label">Last Name</label>
                        <div class="col-sm-7">
                            <input type="text" class="form-control @error('last_name') is-invalid @enderror" id="last_name" name="last_name" value="{{ old('last_name') }}">
                                @error('last_name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-3 text-right control-label col-form-label">Gender</label>
                        <div class="col-sm-7">
                            <select class="form-control" name="gender">
                                <option></option>
                                <option value="Male" {{ old('gender') == 'Male'?"selected":"" }}>Male</option>
                                <option value="Female" {{ old('gender') == 'Female'?"selected":"" }}>Female</option>
                            </select>
                            @error('gender')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    {{-- <div class="form-group row">
                        <label for="email1" class="col-sm-3 text-right control-label col-form-label">Date of Birth</label>
                        <div class="col-sm-7">
                            <input type="date" class="form-control @error('date_of_birth') is-invalid @enderror" id="date_of_birth" name="date_of_birth" value="{{ old('date_of_birth') }}">
                            @error('date_of_birth')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div> --}}

                    <div class="form-group row">
                        <label class="col-sm-3 text-right control-label col-form-label">Photo</label>
                        <div class="col-sm-7">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Upload</span>
                                </div>
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" name="photo" id="inputGroupFile01">
                                    <label class="custom-file-label" for="inputGroupFile01">Choose Image</label>
                                </div>
                                @error('photo')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="card-body">
                    <h4 class="card-title">Contact Information</h4>
                    <div class="form-group row">
                        <label for="cono1" class="col-sm-3 text-right control-label col-form-label">1) Phone Number</label>
                        <div class="col-sm-7">
                            <input type="text" class="form-control @error('phone_number_one') is-invalid @enderror" id="phone_number_one" name="phone_number_one" value="{{ old('phone_number_one') }}">
                            @error('phone_number_one')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="cono1" class="col-sm-3 text-right control-label col-form-label">2) Phone Number</label>
                        <div class="col-sm-7">
                            <input type="text" class="form-control @error('phone_number_two') is-invalid @enderror" id="phone_number_two" name="phone_number_two" value="{{ old('phone_number_two') }}">
                            @error('phone_number_two')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="com1" class="col-sm-3 text-right control-label col-form-label">Residential Address</label>
                        <div class="col-sm-7">
                            <input type="text" class="form-control @error('residential_address') is-invalid @enderror" id="residential_address" name="residential_address" value="{{ old('residential_address') }}">
                            @error('residential_address')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="com1" class="col-sm-3 text-right control-label col-form-label">Landmark</label>
                        <div class="col-sm-7">
                            <input type="text" class="form-control @error('landmark') is-invalid @enderror" id="landmark" name="landmark" value="{{ old('landmark') }}">
                            @error('landmark')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    {{-- <div class="form-group row">
                        <label for="com1" class="col-sm-3 text-right control-label col-form-label">House Number/ GPS</label>
                        <div class="col-sm-7">
                            <input type="text" class="form-control @error('house_number') is-invalid @enderror" id="house_number" name="house_number" value="{{ old('house_number') }}">
                            @error('house_number')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div> --}}

                    <div class="form-group row">
                        <label for="com1" class="col-sm-3 text-right control-label col-form-label">Occupation</label>
                        <div class="col-sm-7">
                            <input type="text" class="form-control @error('employer') is-invalid @enderror" id="employer" name="employer" value="{{ old('employer') }}">
                            @error('employer')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                </div>
                <hr>
                <div class="card-body">
                    <h4 class="card-title">Next of Kin</h4>
                    <div class="form-group row">
                        <label for="cono1" class="col-sm-3 text-right control-label col-form-label">Full Name</label>
                        <div class="col-sm-7">
                            <input type="text" class="form-control @error('full_name_of_next_of_kin') is-invalid @enderror" id="full_name_of_next_of_kin" name="full_name_of_next_of_kin" value="{{ old('full_name_of_next_of_kin') }}">
                            @error('full_name_of_next_of_kin')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="cono1" class="col-sm-3 text-right control-label col-form-label">Phone Number </label>
                        <div class="col-sm-7">
                            <input type="text" class="form-control @error('phone_number_of_next_of_kin') is-invalid @enderror" id="phone_number_of_next_of_kin" name="phone_number_of_next_of_kin" value="{{ old('phone_number_of_next_of_kin') }}">
                            @error('phone_number_of_next_of_kin')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                </div>
                <hr>
                <div class="card-body">
                    <h4 class="card-title">Account Information</h4>
                    <div class="form-group mb-3 row">
                        <label for="fname" class="col-sm-3 text-right control-label col-form-label">Date of Registration</label>
                        <div class="col-sm-7">
                            <input type="date" class="form-control @error('registration_date') is-invalid @enderror" id="registration_date" name="registration_date" value="{{ old('registration_date', date('Y-m-d')) }}">
                            @error('registration_date')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="cono1" class="col-sm-3 text-right control-label col-form-label">Amount Type</label>
                        <div class="col-sm-7">
                            <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" id="customRadioInline1" checked name="account_type" class="custom-control-input" value="{{ App\Models\Account::SUSU }}">
                                <label class="custom-control-label" for="customRadioInline1">Susu Account</label>
                            </div>

                            <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" id="customRadioInline2" name="account_type" class="custom-control-input" value="{{ App\Models\Account::SAVINGS }}">
                                <label class="custom-control-label" for="customRadioInline2">Savings Account</label>
                            </div>

                            @error('account_type')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="cono1" class="col-sm-3 text-right control-label col-form-label">Payment Amount</label>
                        <div class="col-sm-7">
                            <input type="text" class="form-control @error('payment_amount') is-invalid @enderror" id="payment_amount" name="payment_amount" value="{{ old('payment_amount',0) }}">
                            @error('payment_amount')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="cono1" class="col-sm-3 text-right control-label col-form-label">Passbook Fee</label>
                        <div class="col-sm-7">
                            <input type="text" class="form-control @error('passbook') is-invalid @enderror" id="passbook" name="passbook" value="{{ old('passbook',0) }}">
                            @error('passbook')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="cono1" class="col-sm-3 text-right control-label col-form-label">Receive SMS Notifications?</label>
                        <div class="col-sm-7">
                            <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" id="smsopt1" checked name="sms_option" class="custom-control-input" value="1">
                                <label class="custom-control-label" for="smsopt1">Yes</label>
                            </div>

                            <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" id="smsopt2" name="sms_option" class="custom-control-input" value="0">
                                <label class="custom-control-label" for="smsopt2">No</label>
                            </div>

                            @error('sms_option')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-3 text-right control-label col-form-label">ID Type</label>
                        <div class="col-sm-7">
                            <select class="form-control" name="id_type">
                                <option></option>
                                <option value="Ghana Card" {{ old('id_type') == 'Ghana Card'?"selected":"" }}>Ghana Card</option>
                                <option value="Voter's ID" {{ old('id_type') == "Voter's ID"?"selected":"" }}>Voter's ID</option>
                                <option value="Driver's License" {{ old('id_type') == "Driver's License"?"selected":"" }}>Driver's License</option>
                                <option value="Passport" {{ old('id_type') == 'Passport'?"selected":"" }}>Passport</option>
                                <option value="NHIS" {{ old('id_type') == 'NHIS'?"selected":"" }}>NHIS</option>
                            </select>
                            @error('id_type')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="cono1" class="col-sm-3 text-right control-label col-form-label">ID Number</label>
                        <div class="col-sm-7">
                            <input type="text" class="form-control @error('id_number') is-invalid @enderror" id="id_number" name="id_number" value="{{ old('id_number') }}">
                            @error('id_number')
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
                        <a href="{{ route('accounts.index') }}" class="btn btn-dark waves-effect waves-light">Cancel</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
