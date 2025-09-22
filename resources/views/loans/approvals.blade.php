@extends('layouts.app')

@section('title', 'Loan Approvals')

@section('content')
    @foreach ($users as $user)
        @if ($user->loans->where('approval_status', 0)->isNotEmpty())
        <div class="card w-100">
            <form action="{{ route('approve-selected-withdrawals') }}" method="post">
                @csrf
                <div class="card-header bg-white">
                    <div class="row">
                        <div class="col">
                            <h3 class="card-title mb-0">Pending Loan Approval</h3>
                            <h4 class="mb-0">Agent: {{ $user->name }}</h4>
                        </div>
                        <div class="col text-right">
                            @can('approve', 'App\Models\User')
                            <a href="{{ route('approve-all-loans','agent='.$user->id) }}" class="btn btn-info">Approve All</a>
                            @endcan
                        </div>
                    </div><hr>
                </div>
                <div class="card-body collapse show">
                    <div class="table-responsive no-wrap">
                        <table class="table product-overview v-middle file_export">
                            <thead>
                                <tr>
                                    <th class="border-0">#</th>
                                    <th class="border-0">Photo</th>
                                    <th class="border-0">Client</th>
                                    <th>Principal</th>
                                    <th>Interest</th>
                                    <th class="border-0">Total <br> Loan Amount</th>
                                    <th>Duration</th>
                                    <th class="border-0">Date</th>
                                    @can('approve', 'App\Models\User')
                                    <th class="border-0"></th>
                                    @endcan
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($user->loans->where('approval_status', 0)->sortBy('account_number') as $loan)
                                <tr>
                                    <td>
                                        {{ $loop->iteration }}
                                    </td>
                                    <td>
                                        <img src="{{ $loan->account->profile_photo }}" alt="{{ $loan->account->full_name }}" width="50" height="50" class="rounded-circle">
                                    </td>
                                    <td>{{ $loan->account->full_name }} <br>{{ $loan->account_number }}</>
                                    <td class="text-success"><b>GHS {{ number_format($loan->principal_amount,2) }}</b></td>
                                    <td class="text-success"><b>GHS {{ number_format($loan->interest,2) }}</b></td>
                                    <td class="text-success"><b>GHS {{ number_format($loan->interest + $loan->principal_amount,2) }}</b></td>
                                    <td>{{ $loan->duration }}</td>
                                    <td>{{ $loan->date }}</td>
                                    <td>
                                        @can('approve', 'App\Models\User')
                                        <a href="{{ route('approve-loan', $loan) }}" class="btn btn-sm btn-light-primary text-primary">
                                            Approve
                                        </a><br>
                                        <a href="{{ route('remove-loan', $loan) }}" class="btn btn-sm btn-light-danger text-danger">
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
    @endforeach
@endsection

@section('scripts')
    <script type="text/javascript">
        $(document).ready(function(){
            $('.select_all').on('click',function(){
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
