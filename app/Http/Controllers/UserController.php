<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * Handle user registration.
     */
    public function register(Request $request)
    {
        // Validate the input
        $validator = Validator::make($request->all(), [
            'nama_lengkap' => 'required|string|max:100',
            'nis' => 'nullable|integer|unique:users,nis',
            'jurusan_id' => 'required|exists:data_jurusan,id',
            'email' => 'required|string|email|max:255|unique:users,email',
            'no_hp' => 'required|string|max:15',
            'role_id' => 'required|exists:roles,id',
            'password' => 'required|string|min:6|confirmed',
        ]);

        // If validation fails, return errors
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Create the user
        $user = User::create([
            'nama_lengkap' => $request->nama_lengkap,
            'nis' => $request->nis,
            'jurusan_id' => $request->jurusan_id,
            'email' => $request->email,
            'no_hp' => $request->no_hp,
            'role_id' => $request->role_id,
            'password' => Hash::make($request->password),
        ]);

        // Return the created user
        return response()->json(['message' => 'User registered successfully!', 'user' => $user], 201);
    }
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            if ($user->role_id == 1) {
                return redirect()->intended('admin/')->with('username', $user->name);
            } elseif ($user->role_id == 2) {
                return redirect()->intended('user/');
            } else {
                return redirect()->intended('/');
            }
        }

        // Authentication failed
        return redirect('/')->withErrors([
            'error' => 'password atau username salah',
        ]);
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }

    public function dashboard () {
        return view('pages.user.dashboard');
    }
}
