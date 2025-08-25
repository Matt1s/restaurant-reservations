<?php
// app/Services/ReservationService.php

namespace App\Services;

use App\Models\Table;
use App\Models\Reservation;
use Carbon\Carbon;

class ReservationService
{
    public function getAvailableTables($datetime, $partySize)
    {
        return Table::where('is_active', true)
            ->where('capacity', '>=', $partySize)
            ->whereDoesntHave('reservations', function ($query) use ($datetime) {
                $query->where('reservation_datetime', $datetime)
                      ->whereIn('status', ['pending', 'confirmed']);
            })
            ->get();
    }

    public function createReservation($userId, $tableId, $datetime, $partySize, $specialRequests = null)
    {
        $table = Table::findOrFail($tableId);
        
        if (!$table->is_active) {
            throw new \Exception('Table is not currently available for reservations.');
        }
        
        if (!$table->isAvailableAt($datetime)) {
            throw new \Exception('Table is not available at this time.');
        }

        if ($table->capacity < $partySize) {
            throw new \Exception('Table capacity is insufficient for party size.');
        }

        return Reservation::create([
            'user_id' => $userId,
            'table_id' => $tableId,
            'reservation_datetime' => $datetime,
            'party_size' => $partySize,
            'special_requests' => $specialRequests,
            'status' => 'pending',
        ]);
    }

    public function getTimeSlots($date)
    {
        $slots = [];
        $pragueTime = Carbon::now('Europe/Prague');
        $reservationDate = Carbon::parse($date, 'Europe/Prague');
        
        // Restaurant hours: 17:00 - 21:00 (5PM - 9PM)
        $start = $reservationDate->copy()->setTime(17, 0);
        $end = $reservationDate->copy()->setTime(21, 0);

        while ($start <= $end) {
            // If it's today, only show times that are in the future (Prague timezone)
            if ($reservationDate->isToday() && $start->lte($pragueTime)) {
                $start->addHour();
                continue;
            }
            
            $slots[] = $start->format('H:i');
            $start->addHour();
        }

        return $slots;
    }
}