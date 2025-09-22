@extends('layouts.app')

@section('title', 'User Accounts')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h3 class="card-title"> @yield('title') <a href="{{ route('users.create') }}" class="btn btn-sm btn-success">Add New User</a></h3><hr>
                <div class="table-responsive">
                    <table id="file_export" class="file_export table table-striped table-bordered display">
                        <thead>
                            <tr>
                                <th>S/N</th>
                                <th>Username</th>
                                <th>Email</th>
                                <th>Phone Number</th>
                                <th>Account Type</th>
                                <th class="text-center">No of Accounts Created</th>
                                <th>Account Status</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->phone_number }}</td>
                                <td>{{ ucwords($user->role) }}</td>
                                <td class="text-center">{{ $user->accounts->count() }}</td>
                                <td class="text-center">
                                    @if ($user->deleted_at !='')
                                        <span class="badge badge-pill badge-danger">Inactive</span>
                                    @else
                                        <span class="badge badge-pill badge-success">Active</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('users.edit', $user) }}" class="btn btn-success pl-3"><i class="ti-pencil-alt"></i></a>
                                    @if ($user->deleted_at !='')
                                    <a href="{{ route('activate', $user) }}" class="btn btn-warning pl-3">Activate</a>
                                    @else
                                    <form action="{{ route('users.destroy', $user->id) }}" method="POST" style="display: inline" onsubmit="return confirm('Are you sure you want to deactivate account?');">
                                        <input type="hidden" name="_method" value="DELETE">
                                        {{ csrf_field() }}
                                        <button class="btn btn-danger">Deactivate</button>
                                    </form>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
