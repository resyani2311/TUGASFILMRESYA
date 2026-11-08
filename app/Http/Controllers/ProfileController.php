<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

/**
 * Profile SELALU milik akun yang sedang login (tidak ada parameter id),
 * sehingga data pengguna lain tidak dapat dilihat/diubah lewat fitur ini.
 */
class ProfileController extends Controller
{
    public function show(Request $request): View
    {
        $user = $request->user()->loadCount('kritiks');

        $kritiks = $user->kritiks()->with('film')->latest()->take(10)->get();

        return view('profile.show', compact('user', 'kritiks'));
    }

    public function edit(Request $request): View
    {
        return view('profile.edit', ['user' => $request->user()]);
    }

    public function update(Request $request): RedirectResponse
    {
        $user = $request->user();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'alpha_dash', 'max:255', Rule::unique('users', 'username')->ignore($user->id)],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users', 'email')->ignore($user->id)],
            'avatar' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'current_password' => ['nullable', 'required_with:password', 'current_password'],
            'password' => ['nullable', 'confirmed', 'min:8'],
        ], [
            'current_password.required_with' => 'Password saat ini wajib diisi untuk mengganti password.',
            'current_password.current_password' => 'Password saat ini tidak sesuai.',
        ]);

        $data = [
            'name' => $validated['name'],
            'username' => $validated['username'],
            'email' => $validated['email'],
        ];

        if ($request->hasFile('avatar')) {
            $user->deleteAvatarFile();
            $data['avatar'] = $request->file('avatar')->store('avatars', 'public');
        } elseif ($request->boolean('remove_avatar')) {
            $user->deleteAvatarFile();
            $data['avatar'] = null;
        }

        if (! empty($validated['password'])) {
            $data['password'] = $validated['password'];
        }

        // Hanya field di atas yang diubah: role_id tidak pernah diterima dari request.
        $user->update($data);

        return redirect()->route('profile.show')->with('success', 'Profile berhasil diperbarui.');
    }
}
