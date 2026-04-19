<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\TourPackage;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $totalBookings    = Booking::count();
        $pendingBookings  = Booking::where('status', 'pending')->count();
        $confirmedBookings = Booking::where('status', 'confirmed')->count();
        $totalRevenue     = Booking::whereIn('status', ['confirmed', 'completed'])->sum('total_price');
        $totalPackages    = TourPackage::where('is_active', true)->count();
        $totalCustomers   = User::where('role', '!=', 1)->count();

        $recentBookings = Booking::with(['user', 'tourSchedule.tourPackage'])
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalBookings', 'pendingBookings', 'confirmedBookings',
            'totalRevenue', 'totalPackages', 'totalCustomers',
            'recentBookings'
        ));
    }
}
