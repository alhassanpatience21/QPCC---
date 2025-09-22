<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\Hash;
use RealRashid\SweetAlert\Facades\Alert;

class UserController extends Controller
{
    public function index()
    {
        $this->authorize('view-any', User::class);

        $users = User::notAdmin()->withTrashed()->get();
        return view('users.index', compact('users'));
    }

    public function create()
    {
        $this->authorize('view-any', User::class);
        return view('users.create');
    }

    public function store(UserRequest $request)
    {
        $this->authorize('view-any', User::class);
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->role = $request->account_type;
        $user->password = Hash::make($request->password);
        $user->phone_number = $request->phone_number;
        $user->save();

        Alert::success('Success', 'User account created successfully');
        return redirect()->route('users.index');
    }

    public function show(User $user)
    {
        $this->authorize('view-any', User::class);
        return view('users.show', compact('user'));
    }

    public function edit(User $user)
    {
        $this->authorize('view-any', User::class);
        return view('users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $this->authorize('view-any', User::class);
        $user->name = $request->name;
        $user->role = $request->account_type;
        $user->phone_number = $request->phone_number;
        $user->password = $request->password == '' ? $user->password : Hash::make($request->password);
        $user->save();

        Alert::success('Success', 'User account updated successfully');
        return redirect()->route('users.index');
    }

    public function destroy(User $user)
    {
        $this->authorize('view-any', User::class);

        $user->delete();

        return redirect()->back();
    }
}
