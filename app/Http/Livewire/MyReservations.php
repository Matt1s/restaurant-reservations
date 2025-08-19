<?php
// app/Http/Livewire/MyReservations.php

namespace App\Http\Livewire;

use App\Models\Reservation;
use Livewire\Component;

class MyReservations extends Component
{
    public function cancelReservation($reservationId)
    {
        $reservation = Reservation::where('id', $reservationId)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        if (!$reservation->canBeCancelled()) {
            session()->flash('error', 'Cannot cancel this reservation. Cancellations must be made at least 2 hours before the reservation time.');
            return;
        }

        $reservation->update(['status' => 'cancelled']);
        session()->flash('message', 'Reservation cancelled successfully.');
    }

    public function render()
    {
        $reservations = Reservation::with('table')
            ->where('user_id', auth()->id())
            ->orderBy('reservation_datetime', 'desc')
            ->get();

        return view('livewire.my-reservations', compact('reservations'));
    }
}