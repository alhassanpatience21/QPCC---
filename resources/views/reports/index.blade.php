@extends('layouts.app')

@section('title', 'Reports')

@section('content')
<div class="container mx-auto row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h3 class="card-title"> @yield('title')</h3>
            </div>
            <hr>
            <form class="form-horizontal" action="{{ route('reports.filter') }}" method="POST">
                @method('POST')
                @csrf
                <div class="card-body">
                    <div class="form-group row">
                        <label for="lname" class="col-sm-3 text-right control-label col-form-label">Type</label>
                        <div class="col-sm-7">
                            <select name="type" id="type" style="width: 100%; height:36px;" class="form-control custom-select select2 @error('type') is-invalid @enderror" >
                                <option value=""></option>
                                <option value="Deposits" {{ old('options') == 'Deposits'?'selected':'' }}>Deposits</option>
                                <option value="Withdrwals" {{ old('options') == 'Individual'?'selected':'' }}>Withdrwals</option>
                                <option value="Commissions" {{ old('options') == 'Individual'?'selected':'' }}>Commissions</option>
                                <option value="Account Opening" {{ old('options') == 'Individual'?'selected':'' }}>Account Opening</option>
                                <option value="sms" {{ old('options') == 'Individual'?'selected':'' }}>SMS Alert</option>
                                <option value="Loan" {{ old('options') == 'Loan'?'selected':'' }}>Loan</option>
                                <option value="Statement" {{ old('options') == 'Statement'?'selected':'' }}>Statement</option>
                            </select>
                            @error('type')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="lname" class="col-sm-3 text-right control-label col-form-label">Options</label>
                        <div class="col-sm-7">
                            <select name="options" id="options" style="width: 100%; height:36px;" class="form-control custom-select select2 @error('options') is-invalid @enderror" >
                                <option value="All">All</option>
                                <option value="Agent" {{ old('options') == 'Agent'?'selected':'' }}>Agent</option>
                                <option value="Individual" {{ old('options') == 'Individual'?'selected':'' }}>Individual</option>
                            </select>
                            @error('options')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row" id="accounts">
                        <label for="lname" class="col-sm-3 text-right control-label col-form-label">Account Number</label>
                        <div class="col-sm-7">
                            <select name="account_number" id="account_number" style="width: 100%; height:36px;" class="form-control custom-select select2 @error('account_number') is-invalid @enderror" id="account_number">
                                <option value=""></option>
                                @foreach ($accounts as $account)
                                    <option value="{{ $account->account_number }}" {{ old('account_number') == $account->account_number?'selected':'' }} data-amount="{{ $account->payment_amount }}" data-profile="{{ $account->profile_photo }}"><b>{{ $account->account_number }}</b> - {{ $account->full_name }}</option>
                                @endforeach
                            </select>
                            @error('account_number')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row" id="agents">
                        <label for="lname" class="col-sm-3 text-right control-label col-form-label">Agent</label>
                        <div class="col-sm-7">
                            <select name="agent" id="agent" style="width: 100%; height:36px;" class="form-control custom-select select2 @error('agent') is-invalid @enderror" id="agent">
                                <option value=""></option>
                                @foreach ($agents as $agent)
                                    <option value="{{ $agent->id }}" {{ old('agent') == $agent->id?'selected':'' }}> {{ $agent->name }}</option>
                                @endforeach
                            </select>
                            @error('agent')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row dates">
                        <label for="lname" class="col-sm-3 text-right control-label col-form-label">From</label>
                        <div class="col-sm-7">
                            <input type="date" id="from" class="form-control @error('from') is-invalid @enderror" id="from" name="from" value="{{ old('from') }}">
                            @error('from')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row dates">
                        <label for="lname" class="col-sm-3 text-right control-label col-form-label">To</label>
                        <div class="col-sm-7">
                            <input type="date" id="to" class="form-control @error('to') is-invalid @enderror" id="to" name="to" value="{{ old('to') }}">
                            @error('to')
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
                        <button type="submit" class="btn btn-info waves-effect waves-light">Generate Report</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $('#agents').hide();
    $('#accounts').hide();

    $('#type').on('change', function() {
            $('.dates').show();
        switch (this.value) {
            case 'Account Opening':
                $('#options').html('<option value="All">All</option><option value="Agent">Agent</option>');
                break;
            case 'sms':
                $('.dates').hide();
                $('#options').html('<option value="All">All</option><option value="1">Suscribers</option><option value="0">Non-Subscribers</option>');
                break;
            case 'Loan':
                $('#options').html('<option value="Disbursement">Disbursement</option><option value="Repayment">Repayment</option><option value="1">Completed Loans</option><option value="0">Outstanding Loans</option>');
                break;
            case 'Statement':
                $('#options').html('<option value="Individual">Individual</option><option value="all_accounts">All Accounts</option>');
                $('#agents').hide();
                $('#accounts').show();
                break;
            case 'Commissions':
                $('#options').html('<option>All</option><option value="pass book">Passbook fee</option><option value="monthly sms fee">Monthly SMS Fee</option><option value="deposit">Deposits</option><option value="withdrawal">Withdrawal</option>');
                break;
            default:
                $('#options').html('<option value="All">All</option><option value="Agent">Agent</option><option value="Individual">Individual</option>');
                break;
        }
    });
    
    $('#options').on('change', function() {
        switch (this.value) {
            case 'Agent':
                $('#agents').show();
                $('#accounts').hide();
                break;
            case 'Individual':
                $('#agents').hide();
                $('#accounts').show();
                break;
            default:
                $('#agents').hide();
                $('#accounts').hide();
                break;
        }
    });
</script>
@endsection
