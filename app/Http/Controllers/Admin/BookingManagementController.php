<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;
use App\Mail\BookingStatusUpdateMail;
use Illuminate\Support\Facades\Mail;

class BookingManagementController extends Controller
{
    public function index(Request $request)
    {
        $query = Booking::with(['user', 'tourSchedule.tourPackage'])->latest();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $query->where('booking_code', 'like', '%' . $request->search . '%')
                  ->orWhereHas('user', fn($q) => $q->where('name', 'like', '%' . $request->search . '%'));
        }

        $bookings = $query->paginate(10)->withQueryString();

        return view('admin.bookings.index', compact('bookings'));
    }

    public function show(Booking $booking)
    {
        $booking->load(['user', 'tourSchedule.tourPackage', 'participants']);
        return view('admin.bookings.show', compact('booking'));
    }

    public function confirm(Booking $booking)
    {
        if ($booking->status !== 'pending') {
        return redirect()->back()->with('error', 'Only pending bookings can be confirmed.');
        }

        $booking->update(['status' => 'confirmed']);

        Mail::to($booking->user->email)->send(new BookingStatusUpdateMail($booking, 'pending'));

        return redirect()->back()->with('success', 'Booking confirmed successfully.');
    }

    public function complete(Booking $booking)
    {
        if ($booking->status !== 'confirmed') {
        return redirect()->back()->with('error', 'Only confirmed bookings can be marked as completed.');
        }

        $booking->update(['status' => 'completed']);

        Mail::to($booking->user->email)->send(new BookingStatusUpdateMail($booking, 'confirmed'));

        return redirect()->back()->with('success', 'Booking marked as completed.');
    }

    public function cancel(Booking $booking)
    {
        if (!in_array($booking->status, ['pending', 'confirmed'])) {
            return redirect()->back()->with('error', 'This booking cannot be cancelled.');
        }

        $previousStatus = $booking->status;
        $booking->tourSchedule->decrement('booked', $booking->total_participants);
        $booking->update(['status' => 'cancelled']);

        Mail::to($booking->user->email)->send(new BookingStatusUpdateMail($booking, $previousStatus));

        return redirect()->back()->with('success', 'Booking cancelled successfully.');
    }
}