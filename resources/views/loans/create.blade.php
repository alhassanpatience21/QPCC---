@extends('layouts.app')

@section('title', 'Disburse Loan')

@section('content')
<div class="container mx-auto row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h3 class="card-title"> @yield('title')</h3>
            </div>
            <hr>
            <form class="form-horizontal" action="{{ route('loans.store') }}" method="POST">
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
                        <label for="lname" class="col-sm-3 text-right control-label col-form-label">Principal Amount - GHS</label>
                        <div class="col-sm-7">
                            <input type="text" id="principal" class="form-control @error('principal') is-invalid @enderror" id="principal" name="principal" value="{{ old('principal',0) }}" autocomplete="off">
                            @error('principal')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group mb-3 row">
                        <label for="lname" class="col-sm-3 text-right control-label col-form-label">Interest - GHS</label>
                        <div class="col-sm-7">
                            <input type="text" id="interest" class="form-control @error('interest') is-invalid @enderror" id="interest" name="interest" value="{{ old('interest',0) }}" autocomplete="off">
                            @error('interest')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group mb-3 row" id="daily_repayment_amount">
                        <label for="lname" class="col-sm-3 text-right control-label col-form-label">Daily Repayment Amt - GHS</label>
                        <div class="col-sm-7">
                            <input type="text" class="form-control @error('daily_repayment_amount') is-invalid @enderror" id="amount" name="daily_repayment_amount" value="{{ old('daily_repayment_amount',0) }}" autocomplete="off">
                            @error('daily_repayment_amount')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group mb-3 row">
                        <label for="lname" class="col-sm-3 text-right control-label col-form-label">Weekly Repayment Amt - GHS</label>
                        <div class="col-sm-7">
                            <input type="text" readonly  class="form-control  @error('weekly_repayment_amount') is-invalid @enderror" id="weekly_repayment_amount" name="weekly_repayment_amount" value="{{ old('weekly_repayment_amount',0) }}" autocomplete="off">
                            @error('weekly_repayment_amount')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group mb-3 row">
                        <label for="fname" class="col-sm-3 text-right control-label col-form-label">Start Date</label>
                        <div class="col-sm-7">
                            <input type="date" class="form-control @error('start_date') is-invalid @enderror" id="start_date" name="start_date" value="{{ old('start_date', date('Y-m-d')) }}">
                            @error('start_date')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group mb-3 row" id="days">
                        <label for="lname" class="col-sm-3 text-right control-label col-form-label">Duration (Days)</label>
                        <div class="col-sm-7">
                            <input type="text" id="duration" class="form-control  @error('duration') is-invalid @enderror" id="duration" name="duration" value="{{ old('duration',0) }}">
                            @error('duration')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group mb-3 row">
                        <label for="fname" class="col-sm-3 text-right control-label col-form-label">End Date</label>
                        <div class="col-sm-7">
                            <input type="date" readonly class="form-control  @error('end_date') is-invalid @enderror" id="end_date" name="end_date" value="{{ old('end_date') }}">
                            @error('end_date')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group mb-3 row">
                        <label for="lname" class="col-sm-3 text-right control-label col-form-label">Agent</label>
                        <div class="col-sm-7">
                            <select name="agent" id="agent" style="width: 100%; height:36px;" class="form-control custom-select select2 @error('agent') is-invalid @enderror" id="agent">
                                <option value=""></option>
                                @foreach ($agents as $agent)
                                    <option value="{{ $agent->id }}" {{ old('agent') == $agent->agent?'selected':'' }} >
                                        {{ $agent->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('agent')
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
                                Loans cannot be modified or updated. Always confirm details before submitting
                            </div>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="card-body">
                    <div class="form-group mb-3 mb-0 text-center">
                        <button type="submit" class="btn btn-purple waves-effect waves-light">Disburse Loan </button>
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
        }else{
            $("#img-cover").hide()
        }
    });

    $("#daily_repayment_amount").delegate("#amount", "keyup", function() {
        let amount = $(this).val() * 1;
        let weeklyAmount = amount * 5;
        $('#weekly_repayment_amount').val(weeklyAmount);

        if (amount < 0 ) {
            $(this).val(0);
            $('#weekly_repayment_amount').val(0);

            alert('The daily repayment amount cannot be less 0');
        }else{
        $('#weekly_repayment_amount').val(weeklyAmount);
        }
    });

    $("#days").delegate("#duration", "keyup", function() {
       var date = new Date($("#start_date").val()),
           days = parseInt($("#duration").val(), 10);

        if(!isNaN(date.getTime())){
            date.setDate(date.getDate() + days);

            $("#end_date").val(date.toInputFormat());
        } else {
            alert("Invalid Date");
        }
    });

     Date.prototype.toInputFormat = function() {
       var yyyy = this.getFullYear().toString();
       var mm = (this.getMonth()+1).toString(); // getMonth() is zero-based
       var dd  = this.getDate().toString();
       return yyyy + "-" + (mm[1]?mm:"0"+mm[0]) + "-" + (dd[1]?dd:"0"+dd[0]); // padding
    };
</script>
@endsection
