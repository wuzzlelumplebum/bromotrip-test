<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name'     => 'Admin BromoTrip',
            'email'    => 'admin@bromotrip.com',
            'password' => Hash::make('password'),
            'role'     => 1,
        ]);

        User::create([
            'name'     => 'Pelanggan Setia',
            'email'    => 'loyal@bromotrip.com',
            'password' => Hash::make('password'),
            'role'     => 2,
        ]);

        User::create([
            'name'     => 'Customer Biasa',
            'email'    => 'customer@bromotrip.com',
            'password' => Hash::make('password'),
            'role'     => 3,
        ]);
    }
}
