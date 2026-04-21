@component('mail::message')
# 🏔️ Booking Confirmed!

Hi **{{ $booking->user->name }}**,

Thank you for choosing **BromoTrip**! We have received your booking and will confirm it shortly.

---

@component('mail::panel')
**📋 Booking Summary**

| | |
|---|---|
| **Booking Code** | {{ $booking->booking_code }} |
| **Package** | {{ $booking->tourSchedule->tourPackage->name }} |
| **Departure Date** | {{ \Carbon\Carbon::parse($booking->tourSchedule->departure_date)->format('d F Y') }} |
| **Meeting Point** | {{ $booking->tourSchedule->tourPackage->meeting_point }} |
| **Duration** | {{ $booking->tourSchedule->tourPackage->duration_days }} Day(s) |
| **Total Participants** | {{ $booking->total_participants }} people |
| **Total Price** | {{ idr($booking->total_price) }} |
| **Status** | ⏳ Pending |
@endcomponent

**What's next?**
Our team will review your booking and send you a confirmation email once it's approved. This usually takes less than 24 hours.

@component('mail::button', ['url' => route('bookings.show', $booking->id), 'color' => 'primary'])
View Booking Details
@endcomponent

If you have any questions, feel free to reply to this email.

Warm regards,
**BromoTrip Team** 🏔️

---
*You received this email because you made a booking on BromoTrip.*
@endcomponent