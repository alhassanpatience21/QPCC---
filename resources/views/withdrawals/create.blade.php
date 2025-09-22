@extends('layouts.app')

@section('title', 'Make Withdrawal')

@section('content')
<div class="container mx-auto row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h3 class="card-title"> @yield('title')</h3>
            </div>
            <hr>
            <form class="form-horizontal" action="{{ route('withdrawals.store') }}" method="POST">
                @method('POST')
                @csrf
                <div class="card-body">
                    <div class="form-group row" id="img-cover">
                        <label for="lname" class="col-sm-3 text-right control-label col-form-label"></label>
                        <div class="col-sm-7 text-center">
                            <img src="" id="image" alt="" class="rounded-circle" height="150px" width="150px">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="fname" class="col-sm-3 text-right control-label col-form-label">Date of Withdrawal</label>
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
                                    <option value="{{ $account->account_number }}" {{ old('account_number') == $account->account_number?'selected':'' }}>
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
                            <select class="form-control" name="account_type" id="account-type">
                            </select>
                            @error('account_type')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="lname" class="col-sm-3 text-right control-label col-form-label">Available Balance</label>
                        <div class="col-sm-7">
                            <input type="text" readonly class="form-control @error('balance') is-invalid @enderror" id="balance" name="balance" value="{{ old('balance',0) }}">
                        </div>
                    </div>

                    <div class="form-group row" id="withdrawal-amount">
                        <label for="lname" class="col-sm-3 text-right control-label col-form-label">Withdrawal Amt</label>
                        <div class="col-sm-7">
                            <input type="text" class="form-control @error('amount') is-invalid @enderror" id="amount" name="amount" value="{{ old('amount',0) }}">
                            <small class="text-danger">The Withdrawal amount cannot be more than the <b>Max Withdrawal Amt</b></small>
                                @error('amount')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="lname" class="col-sm-3 text-right control-label col-form-label">Commission</label>
                        <div class="col-sm-7">
                            <input type="text" readonly class="form-control @error('commission') is-invalid @enderror" id="commission" name="commission" value="{{ old('commission',0) }}">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="lname" class="col-sm-3 text-right control-label col-form-label">Max Withdrawal Amt</label>
                        <div class="col-sm-7">
                            <input type="text" readonly class="form-control @error('maximum_withdrawal_amount') is-invalid @enderror" id="max" name="maximum_withdrawal_amount" value="{{ old('maximum_withdrawal_amount',0) }}">
                        </div>
                    </div>
                </div>
                <hr>
                <div class="card-body">
                    <div class="form-group mb-0 text-center">
                        <button type="submit" class="btn btn-primary waves-effect waves-light">Make Withdrawal</button>
                        <a href="{{ route('withdrawals.index') }}" class="btn btn-dark waves-effect waves-light">Cancel</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        $("#img-cover").hide()
        $("#account_number").change(function (e) {
            e.preventDefault();
            if ($(this).find(':selected').val() != '') {
                $("#img-cover").show()
                // $("#image").attr("src", $(this).find(':selected').attr('data-profile'));
                $('#amount').val(0);

                // var savings = ($(this).find(':selected').attr('data-savings'));
                var account = ($(this).find(':selected').val());
                // var susu = ($(this).find(':selected').attr('data-susu'));
                // var amount = $('#account_number').find(':selected').attr('data-balance');

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    url:'{{ url("/get-data") }}/'+ account,
                    type:'GET',
                    success:function(data){
                        $('#balance').val(data.balance);
                        $('#commission').val(data.commission);
                        $('#image').attr("src", data.photo);
                        if (data.susu) {
                                $('#account-type').html("<option value='susu'>Susu</option>");
                        } else {
                                $('#account-type').html("<option value='savings'>Savings</option>");
                        }

                        $('#max').val(data.max);
                    },
                    error: function(){
                        alert('Something went wrong while fetching account data');
                    },
                });
            }else{
                $("#img-cover").hide();
                $('#amount').val(0);
                $('#commission').val(0);
                $('#balance').val(0);
                $('#max').val(0);
            }
        });
        // $("#account_number").change(function (e) {
        //     e.preventDefault();
        //     if ($(this).find(':selected').val() != '') {
        //         $("#img-cover").show()
        //         $("#image").attr("src", $(this).find(':selected').attr('data-profile'));
        //         $('#amount').val(0);

        //         var savings = ($(this).find(':selected').attr('data-savings'));
        //         var susu = ($(this).find(':selected').attr('data-susu'));
        //         var amount = $('#account_number').find(':selected').attr('data-balance');

        //         if (susu == 1) {
        //             $('#balance').val(amount);
        //             var commission = $('#account_number').find(':selected').attr('data-commission');
        //             $('#commission').val(commission);
        //             $('#max').val(amount - commission);
        //             $('#account-type').html("<option value='susu'>Susu</option>");

        //         }else if (savings == 1) {
        //             $('#balance').val(amount);
        //             $('#max').val(amount);
        //             $('#commission').val(0);
        //             $('#account-type').html("<option value='savings'>Savings</option>");
        //         }else{
        //             $('#account-type').html('');
        //             $('#balance').val(0);
        //         }
        //     }else{
        //         $("#img-cover").hide();
        //         $('#amount').val(0);
        //         $('#commission').val(0);
        //         $('#balance').val(0);
        //         $('#max').val(0);
        //     }
        // });

        $("#withdrawal-amount").delegate("#amount", "keyup", function() {
            let accountType = $('#account-type').find(':selected').val();
            let balance = $('#balance').val() * 1;
            let amount = $(this).val() * 1;
            let commission = $('#commission').val();

            if (accountType == 'savings') {
                let commission = Math.ceil(amount * 0.01);
                $('#commission').val(commission);
                $('#max').val(balance - commission);                   
            }

            if (amount > (balance - commission)) 
            {
                $(this).val(0);
                alert('The withdrawal amount should be less than or equal to the maximum withdrawal amount');
            }
        });

        $("#account-type").change(function (e) {
            let accountType = $('#account-type').find(':selected').val();

            if (accountType != '') {

                if(accountType == 'susu'){
                    var amount = $('#account_number').find(':selected').attr('data-balance');
                    $('#balance').val(amount);
                    var commission = $('#account_number').find(':selected').attr('data-commission');
                    $('#commission').val(commission);
                    $('#max').val(amount - commission);
                }else{
                    var amount = $('#account_number').find(':selected').attr('data-balance');
                    $('#balance').val(amount);
                    $('#max').val(amount);
                    $('#commission').val(0);
                }

            }else{
                $('#amount').val(0);
                $("#number-of-deposits").hide();
            }
        });
    });    
</script>
@endsection
