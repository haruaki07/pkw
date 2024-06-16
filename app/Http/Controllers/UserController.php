<?php

namespace App\Http\Controllers;

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();

        return view('user.index', compact('users'));
    }

    public function create()
    {
        $roles = UserRole::cases();

        return view('user.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string'],
            'role' => ['required', 'integer', Rule::enum(UserRole::class)]
        ]);

        $data['password'] = Hash::make($data["password"]);

        User::create($data);

        return redirect()->route('users.index')->with('status', 'user-created');
    }

    public function edit(User $user)
    {
        $roles = UserRole::cases();

        return view('user.edit', compact('user', 'roles'));
    }

    public function update(Request $request, User $user)
    {

        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', "unique:users,email,{$user->id}"],
            'password' => ['required', 'string'],
            'role' => ['integer', Rule::enum(UserRole::class)]
        ]);

        $user->fill($data);

        if ($user->wasChanged('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->back()->with('status', 'user-updated');
    }

    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->back()->with('status', 'user-deleted');
    }
}
