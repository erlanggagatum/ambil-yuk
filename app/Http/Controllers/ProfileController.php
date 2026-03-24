<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    public function edit()
    {
        $layout = Auth::user()->role === 'admin' ? 'layouts.admin' : 'layouts.app';
        return view('profile.edit', ['layout' => $layout]);
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $rules = [
            'username'     => ['required', 'string', 'max:255', Rule::unique('users')->ignore($user->id)],
            'nickname'     => ['required', 'string', 'max:255'],
            'phone_number' => ['required', 'string', 'max:20'],
            'new_password' => ['nullable', 'string', 'min:8', 'confirmed'],
        ];

        if ($request->filled('new_password')) {
            $rules['current_password'] = ['required', 'current_password'];
        }

        $validated = $request->validate($rules);

        $user->username     = $validated['username'];
        $user->nickname     = $validated['nickname'];
        $user->phone_number = $validated['phone_number'];

        if (!empty($validated['new_password'])) {
            $user->password = $validated['new_password'];
        }

        $user->save();

        return back()->with('success', 'Profil berhasil diperbarui.');
    }
}
