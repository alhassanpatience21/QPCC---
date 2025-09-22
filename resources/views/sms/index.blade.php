@extends('layouts.app')

@section('title', 'SMS')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col">
                        <h3 class="card-title"> @yield('title')</h3>
                        @if ($settings->credits < 11)
                        <div class="alert alert-danger" role="alert">
                            Your SMS balance is {{ $settings->credits }}, please contact support on <b>+233 54 880 1288</b> to top up.
                        </div>
                        @endif
                    </div>
                    <div class="col text-right">
                        @if ($settings->send_messages == 0)
                        <a href="{{ route('sms.index', 'type=enable') }}" class="btn btn-warning btn-rounded">Enable SMS Sending</a>
                        @else
                        <a href="{{ route('sms.index', 'type=disable') }}" class="btn btn-danger btn-rounded text-white">Disable SMS Sending</a>
                        @endif
                    </div>
                </div><hr>
                <div class="table-responsive">
                    <table id="file_export" class="file_export table table-striped table-bordered display">
                        <thead>
                            <tr>
                                <th>S/N</th>
                                <th class="text-dark font-weight-bold">Date</th>
                                <th class="text-dark font-weight-bold">Sent to</th>
                                <th class="text-dark font-weight-bold">Message</th>
                                <th class="text-dark font-weight-bold">Credits</th>
                                <th class="text-dark font-weight-bold">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($sms->take(100) as $sms)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $sms->date_sent }}</td>
                                <td>{{ $sms->recepient }}</td>
                                <td>{{ $sms->message }}</td>
                                <td>{{ $sms->credits }}</td>
                                <td>
                                    @if ($sms->status)
                                    <span class="badge bg-success p-3 text-white">Delivered</span>
                                    @else
                                    <span class="badge bg-danger p-3 text-white">Not Delivered</span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>S/N</th>
                                <th class="text-dark font-weight-bold">Date</th>
                                <th class="text-dark font-weight-bold">Sent to</th>
                                <th class="text-dark font-weight-bold">Message</th>
                                <th class="text-dark font-weight-bold">Credits</th>
                                <th class="text-dark font-weight-bold">Status</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
