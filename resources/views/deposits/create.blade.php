@extends('layouts.app')

@section('title', 'Make Deposit')

@section('content')
<div class="container mx-auto row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h3 class="card-title"> @yield('title')</h3>
            </div>
            <hr>
            <form class="form-horizontal" action="{{ route('deposits.store') }}" method="POST">
                @method('POST')
                @csrf
                <div class="card-body">
                    <div class="form-group mb-3 row" id="img-cover">
                        <label for="lname" class="col-sm-3 text-right control-label col-form-label"></label>
                        <div class="col-sm-7 text-center">
                            <img src="" id="image" alt="" class="rounded-circle" height="150px" width="150px">
                        </div>
                    </div>

                    <div class="form-group mb-3 row">
                        <label for="fname" class="col-sm-3 text-right control-label col-form-label">Date of Deposit</label>
                        <div class="col-sm-7">
                            <input type="date" class="form-control @error('date_of_deposit') is-invalid @enderror" id="date_of_deposit" name="date_of_deposit" value="{{ old('date_of_deposit', date('Y-m-d')) }}">
                            @error('date_of_deposit')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group mb-3 row">
                        <label for="lname" class="col-sm-3 text-right control-label col-form-label">Account</label>
                        <div class="col-sm-7">
                            <select name="account_number" id="account_number" style="width: 100%; height:36px;" class="form-control custom-select select2 @error('account_number') is-invalid @enderror" id="account_number">
                                <option value=""></option>
                                @foreach ($accounts as $account)
                                    <option value="{{ $account->account_number }}" {{ old('account_number') == $account->account_number?'selected':'' }} 
                                        data-amount="{{ $account->payment_amount }}" 
                                        data-savings="{{ $account->savings_account }}" 
                                        data-susu="{{ $account->susu_account }}" 
                                        data-profile="{{ $account->profile_photo }}">
                                        <b>{{ $account->account_number }}</b> - {{ $account->full_name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('account_number')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group mb-3 row">
                        <label class="col-sm-3 text-right control-label col-form-label">Account Type</label>
                        <div class="col-sm-7">
                            <select class="form-control" name="account_type" readonly id="account-type">
                            </select>
                            @error('account_type')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group mb-3 row">
                        <label for="lname" class="col-sm-3 text-right control-label col-form-label">Amount - GHS</label>
                        <div class="col-sm-7">
                            <input type="text" id="amount" class="form-control @error('amount') is-invalid @enderror" id="amount" name="amount" value="{{ old('amount',0) }}" autocomplete="off">
                            @error('amount')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group mb-3 row" id="number-of-deposits">
                        <label for="lname" class="col-sm-3 text-right control-label col-form-label">Number of Deposits</label>
                        <div class="col-sm-7">
                            <input type="text" id="number_of_deposits" class="form-control @error('number_of_deposits') is-invalid @enderror" id="number_of_deposits" name="number_of_deposits" value="{{ old('number_of_deposits',1) }}">
                            @error('number_of_deposits')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group mb-3 row">
                        <label for="lname" class="col-sm-3 text-right control-label col-form-label"></label>
                        <div class="col-sm-7">
                            <div class="alert alert-info" role="alert">
                                Deposits cannot be modified or updated. Always confirm details before submitting
                            </div>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="card-body">
                    <div class="form-group mb-3 mb-0 text-center">
                        <button type="submit" class="btn btn-purple waves-effect waves-light">Make Deposit</button>
                        <a href="{{ route('deposits.index') }}" class="btn btn-dark waves-effect waves-light">Cancel</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $("#img-cover").hide()
    $("#number-of-deposits").hide()
    $("#account_number").change(function (e) {
        e.preventDefault();
        if ($(this).find(':selected').val() != '') {
            $("#img-cover").show()

            $("#image").attr("src", $(this).find(':selected').attr('data-profile'));

            var amount = ($(this).find(':selected').attr('data-amount'));
            var savings = ($(this).find(':selected').attr('data-savings'));
            var susu = ($(this).find(':selected').attr('data-susu'));

            if (susu == 1) {
                $("#number-of-deposits").show();
                $('#amount').val(amount);
                $("#amount").prop("readonly", true);

                $('#account-type').html($('<option>', {
                    value: 'susu',
                    text : 'Susu'
                }));

            }else if (savings == 1) {
                $("#number-of-deposits").hide();
                $("#amount").prop("readonly", false);
                $('#amount').val(0);

                $('#account-type').html($('<option>', {
                    value: 'savings',
                    text : 'Savings'
                }));
            }else{
                $('#account-type').html('');
                $("#amount").prop("readonly", false);
                $('#amount').val(0);
        
                $("#number-of-deposits").hide();
            }
        }else{
            $("#img-cover").hide()
            $('#amount').val(0);
            $("#number-of-deposits").hide();
            $('#account-type').html('');
    
        }
    });
</script>
@endsection
