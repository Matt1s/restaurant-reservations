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
        $start = Carbon::parse($date)->setTime(12, 0); // 12:00 PM
        $end = Carbon::parse($date)->setTime(22, 0);   // 10:00 PM

        while ($start <= $end) {
            $slots[] = $start->format('H:i');
            $start->addMinutes(30);
        }

        return $slots;
    }
}