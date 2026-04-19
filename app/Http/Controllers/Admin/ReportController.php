<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\TourPackage;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $month = $request->get('month', now()->format('Y-m'));

        [$year, $monthNum] = explode('-', $month);

        $bookings = Booking::with(['user', 'tourSchedule.tourPackage'])
            ->whereYear('created_at', $year)
            ->whereMonth('created_at', $monthNum)
            ->latest()
            ->get();

        $totalRevenue    = $bookings->whereIn('status', ['confirmed', 'completed'])->sum('total_price');
        $totalBookings   = $bookings->count();
        $confirmedCount  = $bookings->where('status', 'confirmed')->count();
        $completedCount  = $bookings->where('status', 'completed')->count();
        $cancelledCount  = $bookings->where('status', 'cancelled')->count();
        $pendingCount    = $bookings->where('status', 'pending')->count();

        // Revenue per package
        $revenueByPackage = $bookings->whereIn('status', ['confirmed', 'completed'])
            ->groupBy(fn($b) => $b->tourSchedule->tourPackage->name)
            ->map(fn($group) => [
                'count'   => $group->count(),
                'revenue' => $group->sum('total_price'),
            ]);

        return view('admin.reports.index', compact(
            'bookings', 'month', 'totalRevenue', 'totalBookings',
            'confirmedCount', 'completedCount', 'cancelledCount',
            'pendingCount', 'revenueByPackage'
        ));
    }
}