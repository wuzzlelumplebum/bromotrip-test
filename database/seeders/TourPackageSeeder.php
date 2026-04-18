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
                'description'   => 'Paket wisata melihat sunrise Gunung Bromo dengan pemandu lokal berpengalaman.',
                'itinerary'     => "02.00 - Jemput di hotel\n03.30 - Tiba di Penanjakan\n05.00 - Matahari terbit\n07.00 - Kawah Bromo\n10.00 - Kembali ke hotel",
                'price'         => 350000,
                'duration_days' => 1,
                'meeting_point' => 'Hotel area Cemoro Lawang',
                'is_active'     => true,
            ],
            [
                'name'          => 'Bromo Sunrise + Savana',
                'slug'          => 'bromo-sunrise-savana',
                'description'   => 'Paket lengkap sunrise Bromo dilanjutkan trekking savana Teletubbies dan Bukit Teletubbies.',
                'itinerary'     => "02.00 - Jemput di hotel\n03.30 - Penanjakan\n05.00 - Sunrise\n07.00 - Kawah Bromo\n09.00 - Savana Teletubbies\n12.00 - Kembali",
                'price'         => 550000,
                'duration_days' => 1,
                'meeting_point' => 'Hotel area Cemoro Lawang',
                'is_active'     => true,
            ],
            [
                'name'          => 'Bromo 2 Hari 1 Malam',
                'slug'          => 'bromo-2-hari-1-malam',
                'description'   => 'Paket menginap di Cemoro Lawang, menikmati suasana Bromo dari sore hingga sunrise keesokan harinya.',
                'itinerary'     => "Hari 1:\n13.00 - Check in\n16.00 - Sunset di Penanjakan\nHari 2:\n03.30 - Sunrise\n07.00 - Kawah Bromo\n10.00 - Check out",
                'price'         => 950000,
                'duration_days' => 2,
                'meeting_point' => 'Stasiun Malang / Probolinggo',
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
