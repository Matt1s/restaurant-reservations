<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Reservation;
use App\Models\User;
use App\Models\Table;
use Carbon\Carbon;

class ReservationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::where('email', 'user@user.com')->first();
        $admin = User::where('email', 'admin@admin.com')->first();
        $tables = Table::limit(5)->get();

        if ($user && $tables->count() > 0) {
            // Create some sample reservations
            $reservations = [
                [
                    'user_id' => $user->id,
                    'table_id' => $tables->random()->id,
                    'reservation_datetime' => Carbon::now()->addDays(1)->setTime(19, 0),
                    'party_size' => 4,
                    'special_requests' => 'Window table please',
                    'status' => 'pending',
                ],
                [
                    'user_id' => $user->id,
                    'table_id' => $tables->random()->id,
                    'reservation_datetime' => Carbon::now()->addDays(2)->setTime(20, 0),
                    'party_size' => 2,
                    'special_requests' => null,
                    'status' => 'confirmed',
                ],
                [
                    'user_id' => $user->id,
                    'table_id' => $tables->random()->id,
                    'reservation_datetime' => Carbon::now()->addDays(3)->setTime(18, 30),
                    'party_size' => 6,
                    'special_requests' => 'Birthday celebration',
                    'status' => 'confirmed',
                ],
                [
                    'user_id' => $user->id,
                    'table_id' => $tables->random()->id,
                    'reservation_datetime' => Carbon::now()->subDays(1)->setTime(19, 30),
                    'party_size' => 3,
                    'special_requests' => null,
                    'status' => 'cancelled',
                ],
            ];

            foreach ($reservations as $reservation) {
                Reservation::create($reservation);
            }
        }
    }
}
