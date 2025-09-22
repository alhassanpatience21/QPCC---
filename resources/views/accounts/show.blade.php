@extends('layouts.app')

@section('title', $account->full_name)

@section('content')
<div class="row">
    <div class="col-lg-8 col-xlg-9 col-md-7">
        <div class="card p-5">
            <ul class="nav nav-pills custom-pills" id="pills-tab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link @if(count($errors) == 0 ) active @endif" id="pills-timeline" data-toggle="pill" href="#timeline" role="tab" aria-controls="pills-timeline" aria-selected="false">Account Summary</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="pills-profile-tab" data-toggle="pill" href="#last-month" role="tab" aria-controls="pills-profile" aria-selected="false">Deposits</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="pills-setting-tab" data-toggle="pill" href="#previous-month" role="tab" aria-controls="pills-setting" aria-selected="false">Withdrawals</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="pills-commissions" data-toggle="pill" href="#commissions" role="tab" aria-controls="pills-commissions" aria-selected="false">Commissions</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link @if(count($errors) > 0 ) active @endif" id="pills-setting-tab" data-toggle="pill" href="#profile" role="tab" aria-controls="pills-setting" aria-selected="false">Update Profile</a>
                </li>
            </ul>

            @if(count($errors) > 0 )
            <div class="mt-4 alert alert-danger alert-dismissible fade show" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <ul class="p-0 m-0" style="list-style: none;">
                    @foreach($errors->all() as $error)
                    <li>{{$error}}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <div class="tab-content" id="pills-tabContent">
                <div class="tab-pane fade @if(count($errors) == 0 ) show active @endif" id="timeline" role="tabpanel" aria-labelledby="pills-timeline-tab">
                    <div class="card-body">
                        <div class="profiletimeline mt-0">
                            @foreach($account->summary as $summary)
                            <div class="sl-item">
                                <div class="sl-left"> <img src="https://ui-avatars.com/api/?name={{ $summary->transactionSource->user->name }}&background=507b8c&Color=ffffff" alt="user" class="rounded-circle" /> </div>
                                <div class="sl-right">
                                    <div><a href="javascript:void(0)" class="link"><b>{{ $summary->transactionSource->user->name??'' }}</b></a> <span class="sl-date">{{ $summary->updated_at->diffForHumans() }}</span>
                                        <p>
                                        @if ($summary->description == 'credit')
                                            Account number {{ $summary->account->account_number }} has been credited with <span class="text-success font-weight-bold">{{ moneyFormat($summary->amount) }}</span> on {{ $summary->transaction_date }}. Available Balance: {{ moneyFormat($summary->balance) }}. <b>REF: DEPOSIT</b>
                                        @else
                                            Account number {{ $summary->account->account_number }} has been debited with <span class="text-danger font-weight-bold">{{ moneyFormat($summary->amount) }}</span> on {{ $summary->transaction_date }}. Available Balance: {{ moneyFormat($summary->balance) }}. <b>REF: {{ $summary->description =='debit'?'WITHDRAWAL':'COMMISSION' }}</b>
                                        @endif
                                        </p>
                                        <div class="comment-footer ">
                                            @if( $summary->approval_status) <span class="badge badge-success">Approved</span> @else <span class="badge badge-danger">Pending Approval</span> @endIf </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="tab-pane fade" id="last-month" role="tabpanel" aria-labelledby="pills-profile-tab">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="file_export" class="file_export table table-striped table-bordered display">
                                <thead>
                                    <tr>
                                        <th>S/N</th>
                                        <th>Date</th>
                                        <th>Amount</th>
                                        <th>Recorded By</th>
                                        <th>Approval Status</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($account->deposits as $deposit)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $deposit->date }}</td>
                                        <td>GHS {{ number_format($deposit->amount,2) }}</td>
                                        <td>{{ $deposit->agent->name }}</td>
                                        <td class="text-center">
                                            @if ($deposit->approval_status)
                                            <span class="px-2 py-1 badge bg-success text-white font-weight-100">Approved</span>
                                            @else
                                            <span class="px-2 py-1 badge bg-warning text-white font-weight-100">Pending</span>
                                            @endif
                                        </td>
                                        <td>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>S/N</th>
                                        <th>Date</th>
                                        <th>Amount</th>
                                        <th>Recorded By</th>
                                        <th>Approval Status</th>
                                        <th></th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="previous-month" role="tabpanel" aria-labelledby="pills-profile-tab">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="file_e" class="file_export table table-striped table-bordered display">
                                <thead>
                                    <tr>
                                        <th>S/N</th>
                                        <th>Date</th>
                                        <th>Amount</th>
                                        <th>Recorded By</th>
                                        <th>Approval Status</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($account->withdrawals as $withdrawal)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $withdrawal->date }}</td>
                                        <td>GHS {{ number_format($withdrawal->amount, 2) }}</td>
                                        <td>{{ $withdrawal->agent->name }}</td>
                                         <td>
                                            @if ($withdrawal->approval_status)
                                            <span class="px-2 py-1 badge bg-success text-white font-weight-100">Approved</span>
                                            @else
                                            <span class="px-2 py-1 badge bg-warning text-white font-weight-100">Pending</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if (!$withdrawal->approval_status)
                                                @can('view-any', 'App\Models\User')
                                                    <a href="{{ route('approve-withdrawal', $withdrawal) }}" class="btn btn-sm btn-primary text-white">Approve</a>
                                                @endcan
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>S/N</th>
                                        <th>Date</th>
                                        <th>Amount</th>
                                        <th>Recorded By</th>
                                        <th></th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="commissions" role="tabpanel" aria-labelledby="pills-profile-tab">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="file_export" class="file_export table table-striped table-bordered display">
                                <thead>
                                    <tr>
                                        <th>S/N</th>
                                        <th class="text-dark font-weight-bold">Date</th>
                                        <th class="text-dark font-weight-bold">Amount</th>
                                        <th class="text-dark font-weight-bold">Source</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($account->commissions->where('source', '!=', 'pass book') as $commission)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $commission->date }}</td>
                                        <td>GHS {{ number_format($commission->amount,2) }}</td>
                                        <td>{{ ucfirst($commission->source) }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade @if(count($errors) > 0 ) show active @endif" id="profile" role="tabpanel" aria-labelledby="pills-setting-tab">
                    <div class="card-body">
                        <form class="form-horizontal" action="{{ route('accounts.update',$account) }}" method="POST" enctype="multipart/form-data">
                            @method('PATCH')
                            @csrf
                            <div class="card-body">
                                <h4 class="card-title">Personal Information</h4>
                                <div class="form-group row">
                                    <label for="fname" class="col-sm-3 text-right control-label col-form-label">First Name</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control @error('first_name') is-invalid @enderror" id="first_name" name="first_name" value="{{ $account->first_name }}">
                                        @error('first_name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="lname" class="col-sm-3 text-right control-label col-form-label">Other Names</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control @error('other_names') is-invalid @enderror" id="other_names" name="other_names" value="{{ $account->other_names }}">
                                        @error('other_names')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="lname" class="col-sm-3 text-right control-label col-form-label">Last Name</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control @error('last_name') is-invalid @enderror" id="last_name" name="last_name" value="{{ $account->last_name }}">
                                            @error('last_name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-3 text-right control-label col-form-label">Gender</label>
                                    <div class="col-sm-9">
                                        <select class="form-control" name="gender">
                                            <option></option>
                                            <option value="Male" {{ $account->gender == 'Male'?"selected":"" }}>Male</option>
                                            <option value="Female" {{ $account->gender == 'Female'?"selected":"" }}>Female</option>
                                        </select>
                                        @error('gender')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-3 text-right control-label col-form-label">Photo</label>
                                    <div class="col-sm-9">
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
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control @error('phone_number_one') is-invalid @enderror" id="phone_number_one" name="phone_number_one" value="{{ $account->phone_number_one }}">
                                        @error('phone_number_one')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="cono1" class="col-sm-3 text-right control-label col-form-label">2) Phone Number</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control @error('phone_number_two') is-invalid @enderror" id="phone_number_two" name="phone_number_two" value="{{ $account->phone_number_two }}">
                                        @error('phone_number_two')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="com1" class="col-sm-3 text-right control-label col-form-label">Residential Address</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control @error('residential_address') is-invalid @enderror" id="residential_address" name="residential_address" value="{{ $account->residential_address }}">
                                        @error('residential_address')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="com1" class="col-sm-3 text-right control-label col-form-label">Landmark</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control @error('landmark') is-invalid @enderror" id="landmark" name="landmark" value="{{ $account->landmark }}">
                                        @error('landmark')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="com1" class="col-sm-3 text-right control-label col-form-label">Occupation</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control @error('employer') is-invalid @enderror" id="employer" name="employer" value="{{ $account->employer }}">
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
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control @error('full_name_of_next_of_kin') is-invalid @enderror" id="full_name_of_next_of_kin" name="full_name_of_next_of_kin" value="{{ $account->fullname_of_next_of_kin }}">
                                        @error('full_name_of_next_of_kin')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="cono1" class="col-sm-3 text-right control-label col-form-label">Phone Number </label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control @error('phone_number_of_next_of_kin') is-invalid @enderror" id="phone_number_of_next_of_kin" name="phone_number_of_next_of_kin" value="{{ $account->phone_number_of_next_of_kin }}">
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
                                    <div class="col-sm-9">
                                        <div class="custom-control custom-radio custom-control-inline">
                                            <input type="radio" id="customRadioInline1" {{ ($account->susu_account)?'checked':'' }} name="account_type" class="custom-control-input" value="{{ App\Models\Account::SUSU }}">
                                            <label class="custom-control-label" for="customRadioInline1">Susu Account</label>
                                        </div>

                                        <div class="custom-control custom-radio custom-control-inline">
                                            <input type="radio" id="customRadioInline2" {{ ($account->savings_account)?'checked':'' }} name="account_type" class="custom-control-input" value="{{ App\Models\Account::SAVINGS }}">
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
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control @error('payment_amount') is-invalid @enderror" id="payment_amount" name="payment_amount" value="{{ $account->payment_amount }}">
                                        @error('payment_amount')
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
                                            <input type="radio" id="smsopt1" checked name="sms_option" {{ ($account->sms_option)?'checked':'' }} class="custom-control-input" value="1">
                                            <label class="custom-control-label" for="smsopt1">Yes</label>
                                        </div>

                                        <div class="custom-control custom-radio custom-control-inline">
                                            <input type="radio" id="smsopt2" name="sms_option" class="custom-control-input" {{ ($account->sms_option)?'checked':'' }} value="0">
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
                                            <option value="Ghana Card" {{ $account->id_type == 'Ghana Card'?"selected":"" }}>Ghana Card</option>
                                            <option value="Voter's ID" {{ $account->id_type == "Voter's ID"?"selected":"" }}>Voter's ID</option>
                                            <option value="Driver's License" {{ $account->id_type == "Driver's License"?"selected":"" }}>Driver's License</option>
                                            <option value="Passport" {{ $account->id_type == 'Passport'?"selected":"" }}>Passport</option>
                                            <option value="NHIS" {{ $account->id_type == 'NHIS'?"selected":"" }}>NHIS</option>
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
                                        <input type="text" class="form-control @error('id_number') is-invalid @enderror" id="id_number" name="id_number" value="{{ $account->id_number }}">
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
                                    <button type="submit" class="btn btn-info waves-effect waves-light">Update Account</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card">
            <img class="card-img-top w-100 profile-bg-height"
                src="{{ asset('images/background/profile-bg.jpg') }}" alt="Card image cap">
            <div class="card-body little-profile text-center">
                <div class="pro-img"><img src="{{ $account->profile_photo }}" alt="user"
                        class="rounded-circle shadow-sm" width="128" height="128" /></div>
                <h3 class="mb-0">{{ $account->full_name }}</h3>
                <p>{{ $account->phone_number_one }} | {{ $account->account_number }}</p>
                <b>
                    @if ($account->passbook_status)
                    <span style="color: green"><i class="fa fa-check-circle"></i> Passbook Fee Paid</span>
                    @else
                    <span class="text-danger"><i class="fa fa-info-circle"></i> Passbook Fee Balance : {{ moneyFormat($account->passbook_balance) }}</span>
                    @endif
                </b>
                <p>
                    @if ($account->sms_option)
                    <span style="color: green"><i class="fa fa-bell"></i> Receives SMS Notifications</span>
                    @else
                    <span class="text-danger"><i class="fa fa-bell-slash"></i> No SMS Notifications</span>
                    @endif
                </p>
                <p>
                    <hr>
                    <div class="row text-center mt-3 justify-content-center">
                        <div class="col-6 col-md-4 mt-3">
                            @if ($account->susu_account)
                            <span class="badge badge-pill badge-light">Susu Account</span><br><br>
                            @else
                            <span class="badge badge-pill badge-secondary">Savings Account</span><br><br>
                            @endif
                            <h2 class="mb-0 font-weight-bold text-muted">{{ $account->balance }}</h2><small>Available Balance</small>
                        </div>
                    </div>
                    <div class="row text-center mt-3 justify-content-center">
                        <div class="col-6 col-md-4 mt-3">
                            <h3 class="mb-0 font-weight-light">{{ moneyFormat($account->commissions_paid) }}</h3><small>Commissions Paid</small>
                        </div>
                        <div class="col-6 col-md-4 mt-3">
                            <h3 class="mb-0 font-weight-light">{{ moneyFormat($account->total_deposits) }}</h3><small>Credits</small>
                        </div>
                        <div class="col-6 col-md-4 mt-3">
                            <h3 class="mb-0 font-weight-light">{{ moneyFormat($account->total_withdrawals) }}</h3><small>Debits</small>
                        </div>
                    </div>
                </p>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <h3 style="text-center">Adittional Information</h3><hr>
                @if (!empty($account->gender))
                <small class="text-muted">Gender</small>
                <h6>{{ $account->gender }}</h6>
                @endif

                @if (!empty($account->email))
                <small class="text-muted">Email address</small>
                <h6>{{ $account->email }}</h6>
                @endif

                @if (!empty($account->phone_number_one))
                <small class="text-muted pt-4 db">1. Phone</small>
                <h6>{{ $account->phone_number_one }}</h6>
                @endif

                @if (!empty($account->phone_number_two))
                <small class="text-muted pt-4 db">2. Phone</small>
                <h6>{{ $account->phone_number_two }}</h6>
                @endif

                @if (!empty($account->residential_address))
                <small class="text-muted pt-4 db">Address</small>
                <h6>{{ $account->residential_address }}</h6>
                @endif

                @if (!empty($account->landmark))
                <small class="text-muted pt-4 db">Landmark</small>
                <h6>{{ $account->landmark }}</h6>
                @endif

                @if (!empty($account->fullname_of_next_of_kin))
                <small class="text-muted pt-4 db">Name of next of Kin</small>
                <h6>{{ $account->fullname_of_next_of_kin }}</h6>
                @endif

                @if (!empty($account->phone_number_of_next_of_kin))
                <small class="text-muted pt-4 db">Phone number of next of Kin</small>
                <h6>{{ $account->phone_number_of_next_of_kin }}</h6>
                @endif

                <small class="text-muted pt-4 db">Registered By</small>
                <h6>{{ $account->user->name }}</h6>
                <hr>
                <div class="text-center">
                    <a href="#profile" data-toggle="pill" href="#profile" role="tab" class="mt-1 waves-effect waves-dark btn btn-primary btn-md btn-rounded">Update Profile</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
