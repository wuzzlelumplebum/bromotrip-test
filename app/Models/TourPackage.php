<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TourPackage extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'slug', 'description', 'itinerary',
        'price', 'duration_days', 'meeting_point',
        'thumbnail', 'is_active',
    ];

    public function schedules()
    {
        return $this->hasMany(TourSchedule::class);
    }
}
