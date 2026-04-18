<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookingParticipant extends Model
{
    use HasFactory;

    protected $fillable = [
        'booking_id',
        'name',
        'id_number',
        'birth_date',
        'id_type',
    ];

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }
}
