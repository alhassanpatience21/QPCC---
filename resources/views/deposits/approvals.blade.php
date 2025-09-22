@extends('layouts.app')

@section('title', 'Deposit Approvals')

@section('content')
    @foreach ($users as $user)
        @if ($user->deposits->where('approval_status', 0)->isNotEmpty())
        <div class="card w-100">
            <form action="{{ route('approve-selected-deposits') }}" method="post" id="form-{{ $user->id }}">
                @csrf
                <div class="card-header bg-white">
                    <div class="row">
                        <div class="col">
                            <h3 class="card-title mb-0">Pending Deposit Approval</h3>
                            <h4 class="mb-0">Agent: {{ $user->name }}</h4>
                        </div>
                        <div class="col text-right">
                            @can('approve', 'App\Models\User')
                            <a href="{{ route('approve-all-deposits','agent='.$user->id) }}" class="btn btn-success">Approve All</a>
                            <button type="submit" name="approve_selected" class="btn btn-success">Approve Selected</button>
                            <button type="submit" name="remove"  class="btn btn-danger">Remove Selected</button>
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
                                    <th class="border-0"><input type="checkbox" class="form-check-input select_all" />Select</th>
                                    <th class="border-0">Photo</th>
                                    <th class="border-0">Client</th>
                                    <th class="border-0">Account Number</th>
                                    <th class="border-0">Amount</th>
                                    <th class="border-0">Date</th>
                                    <th class="border-0">Status</th>
                                    @can('approve', 'App\Models\User')
                                    <th class="border-0"></th>
                                    @endcan
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($user->deposits->where('approval_status', 0)->sortBy('account_number') as $deposit)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                        <div class="form-check">
                                            <input class="form-check-input approve-all-deposits" name="deposits[]" value="{{ $deposit->id }}" type="checkbox">
                                        </div>
                                    </td>
                                    <td>
                                        <img src="{{ $deposit->account->profile_photo }}" alt="{{ $deposit->account->full_name }}" width="50" height="50" class="rounded-circle">
                                    </td>
                                    <td>{{ $deposit->account->full_name }}</td>
                                    <td>{{ $deposit->account_number }}</td>

                                    <td>{{ moneyFormat($deposit->amount) }}</td>
                                    <td>{{ $deposit->date }}</td>
                                    <td>
                                        <span
                                            class="px-2 py-1 badge bg-warning text-white font-weight-100">Pending Approval</span>
                                    </td>
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
