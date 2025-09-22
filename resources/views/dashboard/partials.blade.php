<div class="row">
    <div class="col-lg-3 col-md-6">
        <div class="card">
            <div class="card-body">
                <div class="d-flex flex-row">
                    <div class="round round-lg text-white d-inline-block text-center rounded-circle bg-info">
                        <i class="mdi mdi-account"></i></div>
                    <div class="ml-2 align-self-center">
                        <h3 class="mb-0 font-weight-light">{{ $accounts->count() }}</h3>
                        @if (auth()->user()->role == 'Agent')
                        <h5 class="text-muted mb-0">Accounts Created</h5>
                        @else
                        <h5 class="text-muted mb-0">Accounts </h5>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="card">
            <div class="card-body">
                <div class="d-flex flex-row">
                    <div
                        class="round round-lg text-white d-inline-block text-center rounded-circle bg-warning">
                        <i class="mdi mdi-wallet"></i></div>
                    <div class="ml-2 align-self-center">
                        <h3 class="mb-0 font-weight-light">{{ moneyFormat($credits = $deposits->where('approval_status', 1)->sum('amount')) }}</h3>
                        @if (auth()->user()->role == 'Agent')
                        <h5 class="text-muted mb-0">Total Deposits Today</h5>
                        @else
                        <h5 class="text-muted mb-0">Total Deposits</h5>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="card">
            <div class="card-body">
                <div class="d-flex flex-row">
                    <div
                        class="round round-lg text-white d-inline-block text-center rounded-circle bg-primary">
                        <i class="mdi mdi-cart-outline"></i></div>
                    <div class="ml-2 align-self-center">
                        <h3 class="mb-0 font-weight-light">{{ moneyFormat($debits = $withdrawals->where('approval_status', 1)->sum('amount')) }}</h3>
                        @if (auth()->user()->role == 'Agent')
                        <h5 class="text-muted mb-0">Total Withdrawals Today</h5>
                        @else
                        <h5 class="text-muted mb-0">Total Withdrawals</h5>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="card">
            <div class="card-body">
                <div class="d-flex flex-row">
                    <div
                        class="round round-lg text-white d-inline-block text-center rounded-circle bg-danger">
                        <i class="mdi mdi-bullseye"></i>
                    </div>
                    <div class="ml-2 align-self-center">
                        @php
                            $commission = $commissions->where('source', '!=', App\Models\Commission::PASS_BOOK)->sum('amount');
                        @endphp
                        <h3 class="mb-0 font-weight-light">{{ moneyFormat($credits - $debits - $commission)}}</h3>
                        <h5 class="text-muted mb-0">{{ (auth()->user()->role == 'Agent')?"Today's":"Available" }} Balance</h5>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
