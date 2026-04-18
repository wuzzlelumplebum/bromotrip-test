<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TourSchedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'tour_package_id', 'departure_date',
        'quota', 'booked', 'is_active',
    ];

    public function tourPackage()
    {
        return $this->belongsTo(TourPackage::class);
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function availableQuota()
    {
        return $this->quota - $this->booked;
    }
}
