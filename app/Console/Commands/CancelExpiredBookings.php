<?php

namespace App\Console\Commands;

use App\Mail\BookingStatusUpdateMail;
use App\Models\Booking;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class CancelExpiredBookings extends Command
{
    protected $signature = 'bookings:cancel-expired';
    protected $description = 'Automatically cancel pending bookings whose departure date has passed';

    public function handle()
    {
        $expiredBookings = Booking::where('status', 'pending')
            ->whereHas('tourSchedule', function ($q) {
                $q->where('departure_date', '<', now()->toDateString());
            })
            ->with(['tourSchedule', 'user'])
            ->get();

        if ($expiredBookings->isEmpty()) {
            $this->info('No expired bookings found.');
            return;
        }

        foreach ($expiredBookings as $booking) {
            $booking->tourSchedule->decrement('booked', $booking->total_participants);
            $booking->update(['status' => 'cancelled']);

            // Kirim email notifikasi
            try {
                Mail::to($booking->user->email)
                    ->send(new BookingStatusUpdateMail($booking, 'pending'));
            } catch (\Exception $e) {
                $this->warn('Failed to send email for booking: ' . $booking->booking_code);
            }

            $this->info('Cancelled booking: ' . $booking->booking_code);
        }

        $this->info('Total cancelled: ' . $expiredBookings->count() . ' booking(s).');
    }
}
