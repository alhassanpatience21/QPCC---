@extends('layouts.app')

@section('title', 'Passbook Fees')

@section('content')
<div class="row">
    <div class="col-sm-12 col-md-6">
        <div class="card bg-success">
            <div class="card-body text-white">
                <div class="d-flex flex-row">
                    <div class="align-self-center display-6"><i class="ti-wallet"></i></div>
                    <div class="p-2 align-self-center">
                        <h4 class="mb-0 text-white">Total Paid</h4>
                        <span>Income</span>
                    </div>
                    <div class="ml-auto align-self-center">
                        @php
                        $sum = 0;
                            foreach($accounts as $account){
                                $sum += $account->passbook_amount_paid;
                            }
                        @endphp
                        <h2 class="font-weight-medium mb-0 text-white">{{ moneyFormat($sum) }}</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-12 col-md-6">
        <div class="card bg-danger">
            <div class="card-body text-white">
                <div class="d-flex flex-row">
                    <div class="display-6 align-self-center"><i class="ti-user"></i></div>
                    <div class="p-2 align-self-center">
                        <h4 class="mb-0 text-white">Total Arrears</h4>
                        <span>Arrears</span>
                    </div>
                    <div class="ml-auto align-self-center">
                        <h2 class="font-weight-medium mb-0 text-white">{{ moneyFormat($accounts->count() * 5 - $sum) }}</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="card-title">
                    <div class="row">
                        <div class="col">
                           <h3> @yield('title')</h3>
                        </div>
                        <div class="col text-right">
                            <a href="{{ route('passbook-fees-summary') }}" class="btn btn-info">View Payment Summary</a>
                           <button class="btn btn-primary" type="button" data-toggle="modal" data-target="#exampleModalCenter">Add Passbook Fee</button>
                        </div>
                    </div>
                </div><hr>
                <div class="table-responsive">
                    <table id="file_export" class="file_export table table-striped table-bordered display">
                        <thead>
                            <tr>
                                <th class="text-center">S/N</th>
                                <th class="text-dark font-weight-bold">Account Holder</th>
                                <th class="text-dark font-weight-bold">Account Number</th>
                                <th class="text-dark font-weight-bold text-center">Account Type</th>
                                <th class="text-dark font-weight-bold">Amount Paid</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($accounts as $account)
                            <tr>
                                <td class="text-center">{{ $loop->iteration }}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <img src="{{ $account->profile_photo }}" alt="avatar" class="rounded-circle ml-2" width="50" height="50">
                                        <div class="ml-2">
                                            <div class="user-meta-info">
                                                <h5 class="user-name mb-0" data-name="{{ $account->full_name }}">{{ $account->full_name }}</h5>
                                                <small>{{ $account->phone_number_one }}</small>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td>{{ $account->account_number }}</td>
                                <td class="text-center">
                                    @if ($account->savings_account)
                                    <span class="badge badge-pill badge-secondary">Savings</span>
                                    @endif

                                    @if ($account->susu_account)
                                        <span class="badge badge-pill badge-info">Susu</span>
                                    @endif
                                </td>
                                <td>
                                    <b>
                                        @if ($account->passbook_status)
                                        <span style="color: green">{{ moneyFormat($account->passbook_amount_paid) }}</span>
                                        @else
                                        <span class="text-danger">{{ moneyFormat($account->passbook_amount_paid) }}</span>
                                        @endif
                                    </b>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th class="text-center">S/N</th>
                                <th class="text-dark font-weight-bold">Account Holder</th>
                                <th class="text-dark font-weight-bold">Account Number</th>
                                <th class="text-dark font-weight-bold text-center">Account Type</th>
                                <th class="text-dark font-weight-bold">Amount Paid</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="exampleModalCenter" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Passbook Fee Payment</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
               <form action="{{ route('passbook-fees.store') }}" method="post">
                @method('POST')
                @csrf
                    <div class="form-group">
                        <label for="">Select Account</label>
                        <select name="account" class="form-control custom-select select2"  style="width: 100%; height:36px;" id="account" required>
                            <option value=""></option>
                            @foreach ($accounts as $account)
                                @if (!$account->passbook_status)
                                <option value="{{ $account->account_number }}" {{ old('account_number') == $account->account_number?'selected':'' }}
                                    data-amount="{{ $account->passbook_balance }}">
                                    <b>{{ $account->account_number }}</b> - {{ $account->full_name }}
                                </option>
                                @endif
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="">Amount Owed</label>
                        <input type="text" class="form-control" name="amount_owed" id="amount-owed" value="0" readonly>
                    </div>

                    <div class="form-group">
                        <label for="">Amount Paid</label>
                        <input type="text" class="form-control" name="amount" id="amount" value="0" required>
                    </div>
                    <small class="text-danger">Amount Paid should be less than or equal to the amount owed</small>

                    <div class="mt-3 text-center">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-info">Submit</button>
                    </div>
               </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
    <script>
        $("#account").change(function (e) {
            e.preventDefault();
            if ($(this).find(':selected').val() != '') {
                $("#img-cover").show()

                var amount = ($(this).find(':selected').attr('data-amount'));
                $("#amount-owed").prop("readonly", true);
                $('#amount-owed').val(amount);
                $('#amount').val(amount);
            }
        });

        $("#amount").delegate("#amount", "keyup", function() {
            let amountOwed = $('#amount-owed').val();
            let amountPaid = $('#amount').val();

            if (amountPaid > amountOwed || amountPaid < 0) {
                $('#amount').val(0);
                alert("Amount Paid should be less than or equal to ". amountOwed);
            }
        });
    </script>
@endsection
