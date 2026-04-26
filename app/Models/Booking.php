<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'booking_code',
        'user_id',
        'tour_schedule_id',
        'total_participants',
        'price_per_person',
        'total_price',
        'status',
        'notes',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function tourSchedule()
    {
        return $this->belongsTo(TourSchedule::class);
    }

    public function participants()
    {
        return $this->hasMany(BookingParticipant::class);
    }
}
