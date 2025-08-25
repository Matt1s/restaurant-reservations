<?php

namespace App\Http\Livewire;

use App\Models\Reservation;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class AdminDashboard extends Component
{
    use WithPagination;

    public function mount()
    {
        // Check if user is admin
        if (!auth()->user()->isAdmin()) {
            abort(403, 'Unauthorized access.');
        }
    }

    public function cancelReservation($reservationId)
    {
        $reservation = Reservation::findOrFail($reservationId);
        
        $reservation->update(['status' => 'cancelled']);
        
        session()->flash('message', 'Reservation cancelled successfully.');
    }

    public function confirmReservation($reservationId)
    {
        $reservation = Reservation::findOrFail($reservationId);
        
        $reservation->update(['status' => 'confirmed']);
        
        session()->flash('message', 'Reservation confirmed successfully.');
    }

    public function render()
    {
        $reservations = Reservation::with(['user', 'table'])
            ->orderBy('reservation_datetime', 'desc')
            ->paginate(15);

        $stats = [
            'pending' => Reservation::where('status', 'pending')->count(),
            'confirmed' => Reservation::where('status', 'confirmed')->count(),
            'cancelled' => Reservation::where('status', 'cancelled')->count(),
        ];

        return view('livewire.admin-dashboard', compact('reservations', 'stats'));
    }
}
