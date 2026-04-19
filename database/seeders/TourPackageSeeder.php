<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\TourPackage;
use App\Models\TourSchedule;

class TourPackageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $packages = [
            [
                'name'          => 'Bromo Sunrise Basic',
                'slug'          => 'bromo-sunrise-basic',
                'description'   => 'Experience the magical sunrise of Mount Bromo with our experienced local guides.',
                'itinerary'     => "02.00 - Hotel pickup\n03.30 - Arrive at Penanjakan\n05.00 - Sunrise viewing\n07.00 - Bromo Crater\n10.00 - Return to hotel",
                'price'         => 350000,
                'duration_days' => 1,
                'meeting_point' => 'Hotel area Cemoro Lawang',
                'is_active'     => true,
            ],
            [
                'name'          => 'Bromo Sunrise + Savanna',
                'slug'          => 'bromo-sunrise-savana',
                'description'   => 'Complete Bromo sunrise package followed by trekking through the Teletubbies Savanna and Hills.',
                'itinerary'     => "02.00 - Hotel pickup\n03.30 - Penanjakan viewpoint\n05.00 - Sunrise viewing\n07.00 - Bromo Crater\n09.00 - Teletubbies Savanna\n12.00 - Return to hotel",
                'price'         => 550000,
                'duration_days' => 1,
                'meeting_point' => 'Hotel area Cemoro Lawang',
                'is_active'     => true,
            ],
            [
                'name'          => 'Bromo 2 Days 1 Night',
                'slug'          => 'bromo-2-days-1-night',
                'description'   => 'An overnight stay at Cemoro Lawang, enjoying the atmosphere of Bromo from sunset to the next morning sunrise.',
                'itinerary'     => "Day 1:\n13.00 - Check in\n16.00 - Sunset at Penanjakan\nDay 2:\n03.30 - Sunrise viewing\n07.00 - Bromo Crater\n10.00 - Check out",
                'price'         => 950000,
                'duration_days' => 2,
                'meeting_point' => 'Malang / Probolinggo Station',
                'is_active'     => true,
            ],
        ];

        foreach ($packages as $data) {
            $package = TourPackage::create($data);

            // Buat 3 jadwal untuk tiap paket
            $dates = [
                now()->addDays(7),
                now()->addDays(14),
                now()->addDays(21),
            ];

            foreach ($dates as $date) {
                TourSchedule::create([
                    'tour_package_id' => $package->id,
                    'departure_date'  => $date,
                    'quota'           => 20,
                    'booked'          => 0,
                    'is_active'       => true,
                ]);
            }
        }
    }
}
