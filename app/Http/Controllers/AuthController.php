<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\Profile;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

      public function login(LoginRequest $request)
    {

        if (! Auth::attempt($request->only('email', 'password'), $request->boolean('remember'))) {
            return back()->withErrors(['email' => 'Email atau password salah.'])->onlyInput('email');
        }

        $request->session()->regenerate();

        return Auth::user()->isAdmin()
            ? redirect()->intended(route('admin.dashboard'))
            : redirect()->intended(route('home'));
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    /** Registrasi selalu menghasilkan user biasa (role "user"). */
    public function register(RegisterRequest $request)
    {
        $user = DB::transaction(function () use ($request) {
            $profile = Profile::create([
                'umur'   => $request->umur,
                'alamat' => $request->alamat,
                'bio'    => '',
            ]);

            return User::create([
                'name'       => $request->name,
                'email'      => $request->email,
                'password'   => $request->password,
                'role_id'    => Role::where('name', 'user')->value('id'),
                'profile_id' => $profile->id,
            ]);
        });

        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->route('home')->with('success', 'Registrasi berhasil, selamat datang '.$user->name.'!');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home')->with('success', 'Anda telah logout.');
    }
}
