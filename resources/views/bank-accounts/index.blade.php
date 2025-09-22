@extends('layouts.app')

@section('title', 'Bank Accounts')

@section('content')
<div class="widget-content rounded-pill searchable-container list">
    <div class="card card-body">
        <div class="row ">
            <div class="col-md-4 ">
                <form>
                    <input type="text" class="form-control product-search" id="input-search" placeholder="Search for Bank ">
                </form>
            </div>
            <div class="col-md-8 text-right d-flex justify-content-md-end justify-content-center mt-3 mt-md-0">
                <a href="{{ route('bank-accounts.create') }}" id="btn-add-contact" class="btn btn-success">
                    <i class="mdi mdi-account-multiple-plus font-16 mr-1"></i>
                    Add Bank
                </a>
            </div>
        </div>
    </div>

    <div class="card card-body">
        <div class="table-responsive">
            <table class="table table-striped search-table v-middle">
                <thead class="header-item">
                    <th class="text-dark font-weight-bold">Account Name</th>
                    <th class="text-dark font-weight-bold">Account Description</th>
                    <th class="text-dark font-weight-bold">Account Number</th>
                    <th class="text-dark font-weight-bold">Branch</th>
                    <th class="text-center"></th>
                </thead>
                <tbody>
                    @foreach ($banks as $bank)
                    <tr class="search-items">
                        <td>
                            <h5 class="user-name mb-0" data-name="{{ $bank->account_name }}">{{ $bank->account_name }}</h5>
                        </td>
                        <td>
                            <span class="usr-email-addr" data-email="{{ $bank->account_description }}">{{ $bank->account_description }}</span>
                        </td>
                        <td>
                            <span class="usr-location" data-location="{{ $bank->account_number }}">{{ $bank->account_number }}</span>
                        </td>
                        <td>
                            <span class="usr-ph-no" data-phone="{{ $bank->account_branch }}">{{ $bank->account_branch }}</span>
                        </td>
                        <td class="text-center">
                            <a href="{{ route('bank-accounts.show', $bank) }}" class="btn btn-success">Account Summary</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@section('scripts')
    <script src="{{ asset('js/pages/contact/contact.js') }}"></script>
@endsection
