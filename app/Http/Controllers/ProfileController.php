<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateProfileRequest;
use App\Models\Profile;

class ProfileController extends Controller
{
    /** Halaman profile milik sendiri. */
    public function show()
    {
        $user = auth()->user()->load('profile', 'role')->loadCount('kritiks');

        return view('profile.show', compact('user'));
    }

    public function edit()
    {
        $user = auth()->user()->load('profile');

        return view('profile.edit', compact('user'));
    }

    public function update(UpdateProfileRequest $request)
    {
        $user = $request->user();

        $user->name = $request->name;
        $user->email = $request->email;
        if ($request->filled('password')) {
            $user->password = $request->password;
        }

        $profile = $user->profile ?? new Profile();
        $profile->fill([
            'umur'   => $request->umur,
            'alamat' => $request->alamat,
            'bio'    => $request->bio ?? '',
        ])->save();

        $user->profile_id = $profile->id;
        $user->save();

        return redirect()->route('profile.show')->with('success', 'Profile berhasil diperbarui.');
    }
}
