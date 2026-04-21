@component('mail::message')
@if($booking->status === 'confirmed')
# ✅ Booking Confirmed!
@elseif($booking->status === 'completed')
# 🏔️ Tour Completed!
@elseif($booking->status === 'cancelled')
# ❌ Booking Cancelled
@endif

Hi **{{ $booking->user->name }}**,

@if($booking->status === 'confirmed')
Great news! Your booking has been **confirmed**. Please prepare yourself for an amazing adventure!
@elseif($booking->status === 'completed')
Thank you for joining our tour! We hope you had a magical experience at Mount Bromo. We'd love to hear your feedback!
@elseif($booking->status === 'cancelled')
We're sorry to inform you that your booking has been **cancelled**. If you have any questions, please don't hesitate to contact us.
@endif

---

@component('mail::panel')
**📋 Booking Details**

| | |
|---|---|
| **Booking Code** | {{ $booking->booking_code }} |
| **Package** | {{ $booking->tourSchedule->tourPackage->name }} |
| **Departure Date** | {{ \Carbon\Carbon::parse($booking->tourSchedule->departure_date)->format('d F Y') }} |
| **Total Participants** | {{ $booking->total_participants }} people |
| **Total Price** | {{ idr($booking->total_price) }} |
| **Status** | {{ ucfirst($booking->status) }} |
@endcomponent

@if($booking->status === 'confirmed')
**📍 Meeting Point**
{{ $booking->tourSchedule->tourPackage->meeting_point }}

Please arrive **30 minutes early** and bring a valid ID for all participants.
@endif

@component('mail::button', ['url' => route('bookings.show', $booking->id), 'color' => 'primary'])
View Booking Details
@endcomponent

Warm regards,
**BromoTrip Team** 🏔️

---
*You received this email because you have a booking on BromoTrip.*
@endcomponent