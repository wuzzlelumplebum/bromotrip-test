<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TourPackage;
use App\Models\TourSchedule;
use App\Models\Booking;
use App\Models\BookingParticipant;
use Illuminate\Support\Str;

class BookingController extends Controller
{
    public function create(TourSchedule $schedule)
    {
        // Cek apakah jadwal masih tersedia
        if (!$schedule->is_active || $schedule->availableQuota() <= 0) {
            return redirect()->back()->with('error', 'Fully booked or not available');
        }

        $package = $schedule->tourPackage;

        return view('bookings.create', compact('schedule', 'package'));
    }

    public function store(Request $request, TourSchedule $schedule)
    {
        $request->validate([
            'total_participants'         => 'required|integer|min:1|max:' . $schedule->availableQuota(),
            'participants.*.name'        => 'required|string|max:255',
            'participants.*.id_number'   => 'required|string|max:50',
            'participants.*.birth_date'  => 'required|date',
            'participants.*.id_type'     => 'required|in:ktp,passport',
        ], [
            'total_participants.max' => 'Participants exceed the available quota (' . $schedule->availableQuota() . ' quota).',
            'total_participants.min' => 'Minimal 1 peserta.',
        ]);

        // Hitung harga
        $price = $schedule->tourPackage->price;
        if (auth()->user()->role === 2) {
            $price = $price * 0.9; // diskon 10% loyal customer
        }
        $totalPrice = $price * $request->total_participants;

        // Buat booking
        $booking = Booking::create([
            'booking_code'       => 'BT-' . strtoupper(Str::random(8)),
            'user_id'            => auth()->id(),
            'tour_schedule_id'   => $schedule->id,
            'total_participants' => $request->total_participants,
            'total_price'        => $totalPrice,
            'status'             => 'pending',
            'notes'              => $request->notes,
        ]);

        // Simpan peserta
        foreach ($request->participants as $p) {
            BookingParticipant::create([
                'booking_id' => $booking->id,
                'name'       => $p['name'],
                'id_number'  => $p['id_number'],
                'birth_date' => $p['birth_date'],
                'id_type'    => $p['id_type'],
            ]);
        }

        // Update kuota
        $schedule->increment('booked', $request->total_participants);

        return redirect()->route('bookings.show', $booking->id)
            ->with('success', 'Booking successful! Your booking code: ' . $booking->booking_code);
    }

    public function show(Booking $booking)
    {
        // Pastikan hanya pemilik booking yang bisa lihat
        if ($booking->user_id !== auth()->id()) {
            abort(403);
        }

        $booking->load(['tourSchedule.tourPackage', 'participants']);

        return view('bookings.show', compact('booking'));
    }
}
