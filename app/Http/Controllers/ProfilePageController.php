<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class ProfilePageController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $totalBookings     = $user->bookings()->count();
        $pendingBookings   = $user->bookings()->where('status', 'pending')->count();
        $confirmedBookings = $user->bookings()->where('status', 'confirmed')->count();
        $completedBookings = $user->bookings()->where('status', 'completed')->count();
        $cancelledBookings = $user->bookings()->where('status', 'cancelled')->count();
        $totalSpent        = $user->bookings()->whereIn('status', ['confirmed', 'completed'])->sum('total_price');

        return view('profile.index', compact(
            'user', 'totalBookings', 'pendingBookings',
            'confirmedBookings', 'completedBookings',
            'cancelledBookings', 'totalSpent'
        ));
    }

    public function update(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'name'  => 'required|string|max:255',
            'email' => ['required', 'email', Rule::unique('users')->ignore($user->id)],
        ]);

        $user->update([
            'name'  => $request->name,
            'email' => $request->email,
        ]);

        return redirect()->route('profile.index')->with('success', 'Profile updated successfully.');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password'         => 'required|min:8|confirmed',
        ]);

        if (!Hash::check($request->current_password, auth()->user()->password)) {
            return back()->withErrors(['current_password' => 'Current password is incorrect.']);
        }

        auth()->user()->update([
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('profile.index')->with('success', 'Password updated successfully.');
    }
}