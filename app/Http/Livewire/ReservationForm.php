<?php
// app/Http/Livewire/ReservationForm.php

namespace App\Http\Livewire;

use App\Models\Table;
use App\Services\ReservationService;
use Carbon\Carbon;
use Livewire\Component;

class ReservationForm extends Component
{
    public $reservation_date;
    public $reservation_time;
    public $party_size = 2;
    public $special_requests;
    public $selected_table_id;
    public $available_tables = [];
    public $time_slots = [];
    public $step = 1;

    protected $reservationService;

    public function boot(ReservationService $reservationService)
    {
        $this->reservationService = $reservationService;
    }

    public function mount()
    {
        $this->reservation_date = now()->addDay()->format('Y-m-d');
        $this->time_slots = $this->reservationService->getTimeSlots($this->reservation_date);
    }

    protected $rules = [
        'reservation_date' => 'required|date|after_or_equal:today',
        'reservation_time' => 'required',
        'party_size' => 'required|integer|min:1|max:12',
        'selected_table_id' => 'required|exists:tables,id',
        'special_requests' => 'nullable|string|max:500',
    ];

    public function updatedReservationDate()
    {
        $this->time_slots = $this->reservationService->getTimeSlots($this->reservation_date);
        $this->reservation_time = '';
        $this->checkAvailability();
    }

    public function updatedReservationTime()
    {
        $this->checkAvailability();
    }

    public function updatedPartySize()
    {
        $this->checkAvailability();
    }

    public function checkAvailability()
    {
        if ($this->reservation_date && $this->reservation_time && $this->party_size) {
            $datetime = Carbon::parse($this->reservation_date . ' ' . $this->reservation_time);
            
            $this->available_tables = $this->reservationService
                ->getAvailableTables($datetime, $this->party_size);
            
            $this->step = 2;
        }
    }

    public function selectTable($tableId)
    {
        $this->selected_table_id = $tableId;
        $this->step = 3;
    }

    public function makeReservation()
    {
        $this->validate();

        try {
            $datetime = Carbon::parse($this->reservation_date . ' ' . $this->reservation_time);
            
            $this->reservationService->createReservation(
                auth()->id(),
                $this->selected_table_id,
                $datetime,
                $this->party_size,
                $this->special_requests
            );

            session()->flash('message', 'Reservation created successfully!');
            return redirect('/my-reservations');
            
        } catch (\Exception $e) {
            $this->addError('general', $e->getMessage());
        }
    }

    public function goBack()
    {
        if ($this->step > 1) {
            $this->step--;
        }
    }

    public function render()
    {
        return view('livewire.reservation-form');
    }
}