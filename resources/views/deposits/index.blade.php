@extends('layouts.app')

@section('title', 'Deposits')

@section('content')
<div class="row">
    <div class="col-lg-4">
        <div class="card bg-info text-white">
            <div class="card-body">
                <div class="d-flex no-block align-items-center">
                    <a href="JavaScript: void(0);"><i class="display-6 icon icon-check text-white" title="ETH"></i></a>
                    <div class="ml-3 mt-2">
                        <h4 class="font-weight-medium mb-0 text-white">Approved</h4>
                        <h5 class="text-white">{{ moneyFormat($summary['approved']) }}</h5>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card bg-cyan text-white">
            <div class="card-body">
                <div class="d-flex no-block align-items-center">
                    <a href="JavaScript: void(0);"><i class="display-6 icon icon-info text-white" title="LTC"></i></a>
                    <div class="ml-3 mt-2">
                        <h4 class="font-weight-medium mb-0 text-white">Pending</h4>
                        <h5 class="text-white">{{ moneyFormat($summary['pending']) }}</h5>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card bg-orange text-white">
            <div class="card-body">
                <div class="d-flex no-block align-items-center">
                    <a href="JavaScript: void(0);"><i class="display-6 icon icon-badge text-white" title="BTC"></i></a>
                    <div class="ml-3 mt-2">
                        <h4 class="font-weight-medium mb-0 text-white">Grand Total</h4>
                        <h5 class="text-white">{{ moneyFormat($summary['total']) }}</h5>
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
                <div class="row">
                    <div class="col"><h3 class="card-title"> @yield('title')</h3></div>
                    <div class="col text-right">
                        <a href="{{ route('deposits.create') }}" class="btn btn-success">Make Deposit</a>
                    </div>
                </div><hr>
                @if (auth()->user()->role == 'Agent')
                <div class="table-responsive">
                    <table id="deposits-table" class="table table-striped table-bordered display">
                        <thead>
                            <tr >
                                <th class="text-center">S/N</th>
                                <th>Account</th>
                                <th>Amount</th>
                                <th>Agent</th>
                                <th>Date</th>
                                <th class="text-center">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($recentDeposits as $deposit)
                            <tr>
                                <td class="text-center">{{ $loop->iteration }}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <img src="{{ $deposit->account->profile_photo }}" alt="avatar" class="rounded-circle ml-2" width="50" height="50">
                                        <div class="ml-2">
                                            <div class="user-meta-info">
                                                <h5 class="user-name mb-0" data-name="{{ $deposit->account->full_name }}">{{ $deposit->account->full_name }}</h5>
                                                <small>{{ $deposit->account_number }}</small>
                                                @if ($deposit->account->savings_account)
                                                <span class="badge badge-pill badge-secondary">Savings</span>
                                                @endif

                                                @if ($deposit->account->susu_account)
                                                    <span class="badge badge-pill badge-info">Susu</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-success"><b>{{ moneyFormat($deposit->amount) }}</b></td>
                                <td>{{ $deposit->agent->name }}</td>
                                <td>{{ $deposit->date }}</td>
                                <td class="text-center">
                                     @if ($deposit->approval_status)
                                    <span class="px-2 py-1 badge bg-success text-white font-weight-100">Approved</span>
                                    @else
                                    <span class="px-2 py-1 badge bg-warning text-white font-weight-100">Pending Approval</span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th class="text-center">S/N</th>
                                <th>Account</th>
                                <th>Amount</th>
                                <th>Agent</th>
                                <th>Date</th>
                                <th class="text-center">Status</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                @else
                <div class="table-responsive">
                    <table id="deposits-table" class="table table-striped table-bordered display">
                        <thead>
                            <tr>
                                <th class="text-center">S/N</th>
                                <th>Date</th>
                                <th>Total Approved</th>
                                <th>Total Pending <br> Approval</th>
                                <th>Total</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($recentDeposits as $deposit)
                            <tr>
                                <td class="text-center">{{ $loop->iteration }}</td>
                                <td>{{ $deposit->date_of_deposit }}</td>
                                <td>{{ moneyFormat($deposit->approved_total) }}</td>
                                <td>{{ moneyFormat($deposit->pending_total) }}</td>
                                <td>{{ moneyFormat($deposit->total_amount) }}</td>
                                <td class="text-right">
                                    <a href="{{ route('deposits.index', 'date='.$deposit->date_of_deposit) }}" class="btn btn-success">Report</a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th class="text-center">S/N</th>
                                <th>Date</th>
                                <th>Total Approved</th>
                                <th>Total Pending <br> Approval</th>
                                <th>Total</th>
                                <th></th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        // Initialize DataTables with minimal features enabled to improve performance
        $('#deposits-table').DataTable({
            "paging": true,
            "pageLength": 10,
            "lengthMenu": [10, 25, 50],
            "searching": true,
            "ordering": true,
            "info": true,
            "dom": 'Blfrtip',
            "processing": true,
            "buttons": [
                'copy', 'csv', 'excel', 'pdf', 'print'
            ],
            "language": {
                "processing": '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span>'
            },
            "deferRender": true,
            "autoWidth": false
        });
    });
</script>
@endsection