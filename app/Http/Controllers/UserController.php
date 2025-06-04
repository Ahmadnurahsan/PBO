<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    // Tampilkan list user
    public function index()
    {
        $users = User::all();
        return view('users.index', compact('users'));
    }

    // Tampilkan form create user
    public function create()
    {
        return view('users.create');
    }

    // Simpan user baru
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        return redirect()->route('users.index')->with('success', 'User berhasil dibuat');
    }
}
