<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminUserController extends Controller
{
    public function index()
    {
        $users = User::where('role', 'user')
            ->withCount('bookings')
            ->orderBy('nickname')
            ->get();

        return view('admin.users.index', compact('users'));
    }

    public function show(User $user)
    {
        $bookings = $user->bookings()
            ->with('item')
            ->latest()
            ->get();

        return view('admin.users.show', compact('user', 'bookings'));
    }

    public function revealPhone(Request $request, User $user)
    {
        $request->validate(['password' => ['required', 'string']]);

        if (!Hash::check($request->password, Auth::user()->password)) {
            return response()->json(['error' => 'Password salah.'], 403);
        }

        return response()->json(['phone' => $user->phone_number]);
    }
}
