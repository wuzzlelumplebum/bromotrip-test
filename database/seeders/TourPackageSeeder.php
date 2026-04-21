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
                'description'   => 'Experience the magical sunrise of Mount Bromo with our experienced local guides. Perfect for first-time visitors.',
                'itinerary'     => "02.00 - Hotel pickup\n03.30 - Arrive at Penanjakan\n05.00 - Sunrise viewing\n07.00 - Bromo Crater\n10.00 - Return to hotel",
                'price'         => 350000,
                'duration_days' => 1,
                'meeting_point' => 'Hotel area Cemoro Lawang',
                'is_active'     => true,
            ],
            [
                'name'          => 'Bromo Sunrise + Savanna',
                'slug'          => 'bromo-sunrise-savanna',
                'description'   => 'Complete Bromo sunrise package followed by trekking through the iconic Teletubbies Savanna and Hills.',
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
            [
                'name'          => 'Bromo Jeep Adventure',
                'slug'          => 'bromo-jeep-adventure',
                'description'   => 'Explore Mount Bromo in style with a private 4WD jeep. Ideal for groups and families looking for a comfortable ride.',
                'itinerary'     => "03.00 - Hotel pickup by jeep\n04.00 - Penanjakan viewpoint\n05.00 - Sunrise viewing\n07.00 - Bromo Crater by jeep\n09.00 - Whispering Sands\n11.00 - Return to hotel",
                'price'         => 750000,
                'duration_days' => 1,
                'meeting_point' => 'Hotel area Cemoro Lawang',
                'is_active'     => true,
            ],
            [
                'name'          => 'Bromo Photography Tour',
                'slug'          => 'bromo-photography-tour',
                'description'   => 'Specially designed for photography enthusiasts. Visit the best spots for golden hour and blue hour shots around Bromo.',
                'itinerary'     => "01.00 - Hotel pickup\n02.30 - King Kong Hill (blue hour)\n05.00 - Penanjakan sunrise\n07.00 - Bromo Crater\n09.00 - Savanna golden hour\n12.00 - Return to hotel",
                'price'         => 650000,
                'duration_days' => 1,
                'meeting_point' => 'Hotel area Cemoro Lawang',
                'is_active'     => true,
            ],
            [
                'name'          => 'Bromo Backpacker Package',
                'slug'          => 'bromo-backpacker-package',
                'description'   => 'Budget-friendly Bromo tour for solo travelers and backpackers. Join a group and share the experience.',
                'itinerary'     => "03.00 - Meeting point\n04.00 - Penanjakan viewpoint\n05.00 - Sunrise viewing\n07.00 - Bromo Crater (on foot)\n10.00 - End of tour",
                'price'         => 250000,
                'duration_days' => 1,
                'meeting_point' => 'Cemoro Lawang Village',
                'is_active'     => true,
            ],
            [
                'name'          => 'Bromo 3 Days 2 Nights',
                'slug'          => 'bromo-3-days-2-nights',
                'description'   => 'The ultimate Bromo experience. Explore everything from Penanjakan sunrise to Madakaripura Waterfall over 3 days.',
                'itinerary'     => "Day 1:\n12.00 - Arrival & check in\n16.00 - Sunset tour\nDay 2:\n03.00 - Sunrise at Penanjakan\n07.00 - Bromo Crater\n10.00 - Savanna & Whispering Sands\nDay 3:\n08.00 - Madakaripura Waterfall\n14.00 - Drop off",
                'price'         => 1500000,
                'duration_days' => 3,
                'meeting_point' => 'Malang / Surabaya Station',
                'is_active'     => true,
            ],
            [
                'name'          => 'Bromo Midnight Tour',
                'slug'          => 'bromo-midnight-tour',
                'description'   => 'A unique midnight adventure to reach the crater rim before the crowds. Watch the Milky Way above the volcanic landscape.',
                'itinerary'     => "23.00 - Hotel pickup\n01.00 - Start trekking to crater\n03.00 - Crater rim arrival\n05.00 - Sunrise at crater\n07.00 - Return to hotel",
                'price'         => 450000,
                'duration_days' => 1,
                'meeting_point' => 'Hotel area Cemoro Lawang',
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
