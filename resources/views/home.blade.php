@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')

@include('dashboard.partials')

<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-body pb-0">
                <h4 class="card-title">Recent Activities</h4>
                <h6 class="card-subtitle mb-3 pb-1">Latest transactions on accounts</h6><hr>
            </div>
            <div class="comment-widgets scrollable mb-2 common-widget" style="height: 450px;">
                @foreach ($accountTrailBalance as $accountTrialBalance)
                <div class="d-flex flex-row comment-row {{ $loop->first?"active":"" }} p-3">
                    <div class="p-2">
                        <span class="round text-white d-inline-block text-center">
                            <img src="{{ $accountTrialBalance->account->profile_photo }}" class="rounded-circle" alt="user" width="50" height="50">
                        </span>
                    </div>
                    <div class="comment-text active w-100 p-3">
                        <h5 class="text-nowrap">{{ $accountTrialBalance->account->full_name }}</h5>
                        <p class="mb-1 overflow-hidden">
                            @switch($accountTrialBalance->description)
                                @case('credit')
                                    Account number {{ $accountTrialBalance->account->account_number }} has been credited with <span class="text-success font-weight-bold"> {{ moneyFormat($accountTrialBalance->amount) }}</span> on {{ $accountTrialBalance->transaction_date }}. Available Balance: {{ moneyFormat($accountTrialBalance->balance) }}. <b>REF: DEPOSIT</b>
                                    @break
                                @case('debit')
                                    Account number {{ $accountTrialBalance->account->account_number }} has been debited with <span class="text-danger font-weight-bold"> {{ moneyFormat($accountTrialBalance->amount) }}</span> on {{ $accountTrialBalance->transaction_date }}. Available Balance: {{ moneyFormat($accountTrialBalance->balance) }}. <b>REF: {{ $accountTrialBalance->description =='debit'?'WITHDRAWAL':'COMMISSION' }}</b>
                                    @break
                                @case('commission')
                                    Account number {{ $accountTrialBalance->account->account_number }} has been debited with <span class="text-danger font-weight-bold"> {{ moneyFormat($accountTrialBalance->amount) }}</span> on {{ $accountTrialBalance->transaction_date }}. Available Balance: {{ moneyFormat($accountTrialBalance->balance) }}. <b>REF: {{ $accountTrialBalance->description == 'debit'?'WITHDRAWAL':'COMMISSION' }}</b>
                                    @break
                                    @default
                                    Account number {{ $accountTrialBalance->account->account_number }} has paid {{ moneyFormat($accountTrialBalance->amount) }} as part payment of loan amount on {{ $accountTrialBalance->transaction_date }} <b>LOAN OUTSTANDING BAL: {{ moneyFormat($accountTrialBalance->balance) }}</b>
                            @endswitch
                        </p>
                        <div class="comment-footer ">
                            <span class="text-muted pull-right">{{ $accountTrialBalance->transaction_date }} ({{ $accountTrialBalance->updated_at->diffForHumans() }}) | <b><i class="fa fa-user"></i> {{ $accountTrialBalance->transactionSource->user->name??'' }}</b> | @if( $accountTrialBalance->approval_status == 1) <span class="badge badge-success">Approved</span> @else <span class="badge badge-danger">Pending Approval</span> @endIf </span>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        @can('view-any', 'App\Models\User')
        @if ($withdrawals->where('approval_status', 0)->isNotEmpty())
        <div class="card w-100">
            <form action="{{ route('approve-selected-withdrawals') }}" method="post">
                @csrf
                <div class="card-header bg-white">
                    <div class="row">
                        <div class="col">
                            <h4 class="card-title mb-0">Pending Withdrawal Approval</h4>
                        </div>
                        <div class="col text-right">
                            <div class="col text-right">
                                <a href="{{ route('withdrawal.approvals') }}" class="btn btn-info">See All</a>
                                @can('approve', 'App\Models\User')
                                <a href="{{ route('approve-all-withdrawals') }}" class="btn btn-success">Approve All</a>
                                <button type="submit" class="btn btn-success">Approve Selected</button>
                                @endcan
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body collapse show">
                    <div class="table-responsive no-wrap">
                        <table id="file_export" class="file_export table product-overview v-middle">
                            <thead>
                                <tr>
                                    <th class="border-0">Select</th>
                                    <th class="border-0">Photo</th>
                                    <th class="border-0">Client</th>
                                    <th class="border-0">Amount</th>
                                    <th class="border-0">Date</th>
                                    <th class="border-0">Status</th>
                                    <th class="border-0">Agent</th>
                                    <th class="border-0"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($withdrawals->where('approval_status', 0) as $withdrawal)
                                <tr>
                                    <td>
                                        <div class="form-check">
                                            <input class="form-check-input approve-all-deposits" name="withdrawals[]" value="{{ $withdrawal->id }}" type="checkbox">
                                        </div>
                                    </td>
                                    <td>
                                        <img src="{{ $withdrawal->account->profile_photo }}" alt="{{ $withdrawal->account->full_name }}" width="50" height="50" class="rounded-circle">
                                    </td>
                                    <td>{{ $withdrawal->account->full_name }}</td>

                                    <td>GHS {{ number_format($withdrawal->amount, 2) }}</td>
                                    <td>{{ $withdrawal->date_of_withdrawal }}</td>
                                    <td>
                                        <span
                                            class="px-2 py-1 badge bg-warning text-white font-weight-100">Pending</span>
                                    </td>
                                    <td>{{ $withdrawal->user->name }}</td>
                                    <td>
                                        @can('approve', 'App\Models\User')
                                        <a href="{{ route('approve-withdrawal', $withdrawal) }}" class="btn btn-sm btn-light-primary text-primary">
                                            Approve
                                        </a><br>
                                        <a href="{{ route('remove-withdrawal', $withdrawal) }}" class="btn btn-sm btn-light-danger text-danger">
                                            Remove
                                        </a>
                                        @endcan
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </form>
        </div>
        @endif
        @if ($deposits->where('approval_status', 0)->isNotEmpty())
            <div class="card w-100">
                <form action="{{ route('approve-selected-deposits') }}" method="post">
                    @csrf
                    <div class="card-header bg-white">
                        <div class="row">
                            <div class="col">
                                <h4 class="card-title mb-0">Pending Deposit Approval</h4>
                            </div>
                            <div class="col text-right">
                                <a href="{{ route('approvals') }}" class="btn btn-info">See All</a>
                                @can('approve', 'App\Models\User')
                                <a href="{{ route('approve-all-deposits') }}" class="btn btn-success">Approve All</a>
                                <button type="submit" class="btn btn-success">Approve Selected</button>
                                @endcan
                            </div>
                        </div>
                    </div>
                    <div class="card-body collapse show">
                        <div class="table-responsive no-wrap">
                            <table class="table product-overview v-middle file_export">
                                <thead>
                                    <tr>
                                        <th class="border-0"><input type="checkbox" class="form-check-input" id="select_all" />Select</th>
                                        <th class="border-0">Photo</th>
                                        <th class="border-0">Client</th>
                                        <th class="border-0">Amount</th>
                                        <th class="border-0">Date</th>
                                        <th class="border-0">Status</th>
                                        <th class="border-0">Agent</th>
                                        <th class="border-0"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($deposits->where('approval_status', 0) as $deposit)
                                    <tr>
                                        <td>
                                            <div class="form-check">
                                                <input class="form-check-input approve-all-deposits" name="deposits[]" value="{{ $deposit->id }}" type="checkbox">
                                            </div>
                                        </td>
                                        <td>
                                            <img src="{{ $deposit->account->profile_photo }}" alt="{{ $deposit->account->full_name }}" width="50" height="50" class="rounded-circle">
                                        </td>
                                        <td>{{ $deposit->account->full_name }}</td>

                                        <td>GHS {{ number_format($deposit->amount, 2) }}</td>
                                        <td>{{ $deposit->date }}</td>
                                        <td>
                                            <span
                                                class="px-2 py-1 badge bg-warning text-white font-weight-100">Pending</span>
                                        </td>
                                        <td>{{ $deposit->user->name??'' }}</td>
                                        <td>
                                            @can('approve', 'App\Models\User')
                                            <a href="{{ route('approve-deposit', $deposit) }}" class="btn btn-sm btn-light-primary text-primary">
                                                Approve
                                            </a><br>
                                            <a href="{{ route('remove-deposit', $deposit) }}" class="btn btn-sm btn-light-danger text-danger">
                                                Remove
                                            </a>
                                            @endcan
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </form>
            </div>
        @endif

        @endcan
    </div>

    <div class="col-lg-4 col-md-12">
        <div class="card border-bottom border-success">
            <div class="card-body">
                <div class="d-flex no-block align-items-center">
                    <div>
                         @php
                            $commission = $commissions->sum('amount');
                        @endphp
                        <h2 class="text-success">GHS {{ number_format($commission, 2) }}</h2>
                        <h6 class="text-success">Total Commissions</h6>
                    </div>
                    <div class="ml-auto">
                        <span class="text-success display-6"><i class="ti-credit-card"></i></span>
                    </div>
                </div>
            </div>
        </div>
        @can('view-any', 'App\Models\User')
        <div class="card border-bottom border-warning">
            <div class="card-body">
                <div class="d-flex no-block align-items-center">
                    <div>
                        <h2 class="text-warning">{{ $withdrawals->where('approval_status', 0)->count() }}</h2>
                        <h6 class="text-warning">Pending Withdrawal Approvals</h6>
                    </div>
                    <div class="ml-auto">
                        <span class="text-warning display-6"><i class=" ti-check"></i></span>
                    </div>
                </div>
            </div>
        </div>
        <div class="card border-bottom border-danger">
            <div class="card-body">
                <div class="d-flex no-block align-items-center">
                    <div>
                        <h2 class="text-danger">{{ $deposits->where('approval_status', 0)->count() }}</h2>
                        <h6 class="text-danger">Pending Deposit Approvals</h6>
                    </div>
                    <div class="ml-auto">
                        <span class="text-danger display-6"><i class=" ti-check"></i></span>
                    </div>
                </div>
            </div>
        </div>
        <div class="card border-bottom border-primary">
            <div class="card-body">
                <div class="d-flex no-block align-items-center">
                    <div>
                        <h2 class="text-primary">{{ $smsSettings->credits }}</h2>
                        <h6 class="text-primary">Available SMS Balance</h6>
                    </div>
                    <div class="ml-auto">
                        <span class="text-primary display-6"><i class="mdi mdi-email-secure"></i></span>
                    </div>
                </div>
            </div>
        </div>
        @endcan
        <div class="card">
            <div class="card-body bg-success rounded-top">
                <h4 class="text-white card-title">Accounts</h4>
                <h6 class="card-subtitle text-white mb-0 op-5">Recently created accounts</h6>
            </div>
            <div class="card-body p-2">
                <div class="message-box contact-box position-relative mt-2">
                    <h2 class="add-ct-btn position-absolute">
                        <a href="{{ route('accounts.create') }}" class="btn btn-circle btn-lg btn-primary waves-effect waves-dark">+</a>
                    </h2>
                    <div class="message-widget contact-widget position-relative scrollable" style="height: 440px;">
                        @php
                            if(auth()->user()->role == 'Agent'){
                                $accounts = $accounts->where('registered_by', auth()->id());
                            }else{
                                $accounts = $accounts;
                            }
                        @endphp
                        @foreach ($accounts->take(15) as $account)
                        <a href="{{ route('accounts.show', $account) }}" class="py-3 px-2 border-bottom d-block text-decoration-none">
                            <div class="user-img position-relative d-inline-block mr-2">
                                <img src="{{ $account->profile_photo }}" alt="user" height="50" width="50" class="rounded-circle">
                            </div>
                            <div class="mail-contnet d-inline-block align-middle">
                                <h5 class="my-1">{{ $account->full_name }}</h5>
                                <span class="mail-desc font-12 text-truncate overflow-hidden text-nowrap d-block">{{ $account->phone_number_one }}</span>
                                <small>Joined {{ $account->created_at->diffForHumans() }} | Registered By {{ $account->user->name }}</small>
                            </div>
                        </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
    <script type="text/javascript">
        $(document).ready(function(){
            $('#select_all').on('click',function(){
                if(this.checked){
                    $('.approve-all-deposits').each(function(){
                        this.checked = true;
                    });
                }else{
                    $('.approve-all-deposits').each(function(){
                        this.checked = false;
                    });
                }
            });

            $('.approve-all-deposits').on('click',function(){
                if($('.approve-all-deposits:checked').length == $('.approve-all-deposits').length){
                    $('#select_all').prop('checked',true);
                }else{
                    $('#select_all').prop('checked',false);
                }
            });


            // $('#select_all_withdrawals').on('click',function(){
            //     if(this.checked){
            //         $('.approve-all-deposits').each(function(){
            //             this.checked = true;
            //         });
            //     }else{
            //         $('.approve-all-deposits').each(function(){
            //             this.checked = false;
            //         });
            //     }
            // });

            // $('.approve-all-deposits').on('click',function(){
            //     if($('.approve-all-deposits:checked').length == $('.approve-all-deposits').length){
            //         $('#select_all').prop('checked',true);
            //     }else{
            //         $('#select_all').prop('checked',false);
            //     }
            // });
        });
        </script>
@endsection
