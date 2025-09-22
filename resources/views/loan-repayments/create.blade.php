@extends('layouts.app')

@section('title', 'Add a Loan Repayments')

@section('content')
<div class="container mx-auto row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h3 class="card-title"> @yield('title')</h3>
            </div>
            <hr>
            <form class="form-horizontal" action="{{ route('loan-repayments.store') }}" method="POST">
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
                        <label for="fname" class="col-sm-3 text-right control-label col-form-label">Repayment Date</label>
                        <div class="col-sm-7">
                            <input type="date" class="form-control @error('repayment_date') is-invalid @enderror" id="repayment_date" name="repayment_date" value="{{ old('repayment_date', date('Y-m-d')) }}">
                            @error('repayment_date')
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
                                @foreach ($outstandingLoans as $outstandingLoan)
                                    <option value="{{ $outstandingLoan->id }}" {{ old('account_number') == $outstandingLoan->account_number?'selected':'' }}
                                        data-amount="{{ $outstandingLoan->loan_amount }}"
                                        data-dailyAmount="{{ $outstandingLoan->daily_repayment_amount }}"
                                        data-daysLeft="{{ $outstandingLoan->days_left }}"
                                        data-weeklyBalance="{{ $outstandingLoan->weekly_balance }}"
                                        data-outstandingBalance="{{ $outstandingLoan->outstanding_balance }}"
                                        data-profile="{{ $outstandingLoan->account->profile_photo }}">
                                        <b>{{ $outstandingLoan->account_number }}</b> - {{ $outstandingLoan->account->full_name }}
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
                        <label for="lname" class="col-sm-3 text-right control-label col-form-label">Loan Amount - GHS</label>
                        <div class="col-sm-7">
                            <input type="text" id="loan_amount" class="form-control @error('loan_amount') is-invalid @enderror" id="loan_amount" readonly name="loan_amount" value="{{ old('loan_amount',0) }}" autocomplete="off">
                            @error('loan_amount')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group mb-3 row">
                        <label for="lname" class="col-sm-3 text-right control-label col-form-label">Daily Repayment Amt - GHS</label>
                        <div class="col-sm-7">
                            <input type="text" id="daily_repayment_amount" class="form-control @error('daily_repayment_amount') is-invalid @enderror" id="daily_repayment_amount" readonly name="daily_repayment_amount" value="{{ old('daily_repayment_amount',0) }}" autocomplete="off">
                            @error('daily_repayment_amount')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group mb-3 row">
                        <label for="days_left" class="col-sm-3 text-right control-label col-form-label">Days Left</label>
                        <div class="col-sm-7">
                            <input type="text" class="form-control  @error('days_left') is-invalid @enderror" id="days_left" readonly name="days_left" value="{{ old('days_left',0) }}">
                            @error('days_left')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group mb-3 row" id="repayment_amount">
                        <label for="lname" class="col-sm-3 text-right control-label col-form-label">Repayment Amt - GHS</label>
                        <div class="col-sm-7">
                            <input type="text" class="form-control  @error('repayment_amount') is-invalid @enderror" id="amt" name="repayment_amount" value="{{ old('repayment_amount',0) }}" autocomplete="off">
                            @error('repayment_amount')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group mb-3 row">
                        <label for="lname" class="col-sm-3 text-right control-label col-form-label">Weekly Repayment Amt Bal - GHS</label>
                        <div class="col-sm-7">
                            <input type="text" readonly id="weekly_repayment_amount" class="form-control  @error('weekly_repayment_amount') is-invalid @enderror" id="weekly_repayment_amount" name="weekly_repayment_amount" value="{{ old('weekly_repayment_amount',0) }}" autocomplete="off">
                            @error('weekly_repayment_amount')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group mb-3 row">
                        <label for="lname" class="col-sm-3 text-right control-label col-form-label">Outstanding Bal - GHS</label>
                        <div class="col-sm-7">
                            <input type="text" readonly id="outstanding_balance" class="form-control  @error('outstanding_balance') is-invalid @enderror" id="outstanding_balance" name="outstanding_balance" value="{{ old('outstanding_balance',0) }}" autocomplete="off">
                            @error('outstanding_balance')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                </div>
                <hr>
                <div class="card-body">
                    <div class="form-group mb-3 mb-0 text-center">
                        <button type="submit" class="btn btn-purple waves-effect waves-light">Add Repayment</button>
                        <a href="{{ route('loans.index') }}" class="btn btn-dark waves-effect waves-light">Cancel</a>
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
    $("#account_number").change(function (e) {
        e.preventDefault();
        if ($(this).find(':selected').val() != '') {
            $("#img-cover").show()
            $("#image").attr("src", $(this).find(':selected').attr('data-profile'));
            let loanAmount = $(this).find(':selected').attr('data-amount');
            $('#loan_amount').val(loanAmount);
            let dailyRepaymentAmount = $(this).find(':selected').attr('data-dailyAmount');
            $('#daily_repayment_amount').val(dailyRepaymentAmount);
            let daysLeft = $(this).find(':selected').attr('data-daysLeft');
            $('#days_left').val(daysLeft);
            let weeklyRepaymentAmount = $(this).find(':selected').attr('data-weeklyBalance');
            $('#weekly_repayment_amount').val(weeklyRepaymentAmount);
            let outstandingBalance = $(this).find(':selected').attr('data-outstandingBalance');
            $('#outstanding_balance').val(outstandingBalance);
        }else{
            $("#img-cover").hide()
        }
    });

    $("#repayment_amount").delegate("#amt", "keyup", function() {
        let amount = $(this).val() * 1;
        let loanAmount = $('#account_number').find(':selected').attr('data-amount');
        let weeklyBalance = $('#account_number').find(':selected').attr('data-weeklyBalance');
        let outstandingBalance = $('#account_number').find(':selected').attr('data-outstandingBalance');
        let weeklyAmount = (weeklyBalance == 0)?0:weeklyBalance - amount;
        let currentOutstandingBalance = outstandingBalance - amount;

        if (isNaN(amount) || amount < 0 || amount > outstandingBalance ) {
            $(this).val(0);
            $('#weekly_repayment_amount').val(weeklyBalance);
            $('#outstanding_balance').val(outstandingBalance);
            alert('The repayment amount should be less than or equal to the outstanding balance');
        }else{
            if (weeklyAmount < 0) {
                $('#weekly_repayment_amount').val(0);
            }else{
                $('#weekly_repayment_amount').val(weeklyAmount);
            }
            $('#outstanding_balance').val(currentOutstandingBalance);
        }
    });
</script>
@endsection
