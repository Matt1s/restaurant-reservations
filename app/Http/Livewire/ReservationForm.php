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
    public $showTables = false;

    protected $reservationService;

    public function boot(ReservationService $reservationService)
    {
        $this->reservationService = $reservationService;
    }

    public function mount()
    {
        // Check for URL parameters from homepage form
        $hasUrlParams = $this->parseUrlParameters();
        
        // Set default date if not provided (Prague timezone)
        if (!$this->reservation_date) {
            $this->reservation_date = Carbon::now('Europe/Prague')->addDay()->format('Y-m-d');
        }
        
        $this->time_slots = $this->reservationService->getTimeSlots($this->reservation_date);
        
        // If we have valid data from URL, proceed to table selection
        if ($this->isValidUrlData()) {
            $this->checkAvailability();
            $this->showTables = true;
            $this->step = 2;
        } elseif ($hasUrlParams) {
            // Show error if URL params exist but are invalid
            session()->flash('url_error', 'Some reservation details from the homepage were invalid and have been reset. Please verify your selections below.');
        }
    }

    private function parseUrlParameters()
    {
        $request = request();
        $hasParams = false;
        
        // Parse and validate date parameter
        if ($request->has('date')) {
            $hasParams = true;
            $date = $request->get('date');
            if ($this->isValidDate($date)) {
                $this->reservation_date = $date;
            }
        }
        
        // Parse and validate time parameter
        if ($request->has('time')) {
            $hasParams = true;
            $time = $request->get('time');
            if ($this->isValidTime($time)) {
                $this->reservation_time = $time;
            }
        }
        
        // Parse and validate party size parameter
        if ($request->has('party_size')) {
            $hasParams = true;
            $partySize = $request->get('party_size');
            if ($this->isValidPartySize($partySize)) {
                $this->party_size = (int) $partySize;
            }
        }
        
        return $hasParams;
    }

    private function isValidUrlData()
    {
        return $this->reservation_date && 
               $this->reservation_time && 
               $this->party_size &&
               $this->isValidDate($this->reservation_date) &&
               $this->isValidTime($this->reservation_time) &&
               $this->isValidPartySize($this->party_size);
    }

    private function isValidDate($date)
    {
        if (!$date) return false;
        
        try {
            $carbonDate = Carbon::parse($date, 'Europe/Prague');
            $pragueNow = Carbon::now('Europe/Prague');
            
            return $carbonDate->isValid() && 
                   $carbonDate->format('Y-m-d') === $date &&
                   ($carbonDate->isToday() || $carbonDate->isFuture());
        } catch (\Exception $e) {
            return false;
        }
    }

    private function isValidTime($time)
    {
        if (!$time) return false;
        
        // Check if time matches HH:mm format and is within restaurant hours
        if (!preg_match('/^([0-1]?[0-9]|2[0-3]):[0-5][0-9]$/', $time)) {
            return false;
        }
        
        // Restaurant hours: 17:00 - 21:00
        $allowedTimes = ['17:00', '18:00', '19:00', '20:00', '21:00'];
        return in_array($time, $allowedTimes);
    }

    private function isValidPartySize($partySize)
    {
        if (!is_numeric($partySize)) return false;
        
        $size = (int) $partySize;
        return $size >= 1 && $size <= 12;
    }

    protected $rules = [
        'reservation_date' => 'required|date',
        'reservation_time' => 'required',
        'party_size' => 'required|integer|min:1|max:12',
        'selected_table_id' => 'required|exists:tables,id',
        'special_requests' => 'nullable|string|max:500',
    ];

    public function updated($propertyName)
    {
        // Custom validation for Prague timezone
        if ($propertyName === 'reservation_date') {
            $this->validateDate();
        }
        
        if ($propertyName === 'reservation_time') {
            $this->validateTime();
        }
    }

    private function validateDate()
    {
        if (!$this->reservation_date) return;
        
        try {
            $pragueNow = Carbon::now('Europe/Prague');
            $reservationDate = Carbon::parse($this->reservation_date, 'Europe/Prague');
            
            if ($reservationDate->isBefore($pragueNow->startOfDay())) {
                $this->addError('reservation_date', 'Reservation date cannot be in the past (Prague time).');
                return;
            }
        } catch (\Exception $e) {
            $this->addError('reservation_date', 'Invalid date format.');
        }
    }

    private function validateTime()
    {
        if (!$this->reservation_time || !$this->reservation_date) return;
        
        try {
            $pragueNow = Carbon::now('Europe/Prague');
            $reservationDateTime = Carbon::parse($this->reservation_date . ' ' . $this->reservation_time, 'Europe/Prague');
            
            if ($reservationDateTime->isPast()) {
                $this->addError('reservation_time', 'Reservation time cannot be in the past (Prague time).');
                return;
            }
            
            // Check if time is within restaurant hours
            $allowedTimes = ['17:00', '18:00', '19:00', '20:00', '21:00'];
            if (!in_array($this->reservation_time, $allowedTimes)) {
                $this->addError('reservation_time', 'Please select a time between 5:00 PM and 9:00 PM.');
            }
        } catch (\Exception $e) {
            $this->addError('reservation_time', 'Invalid time format.');
        }
    }

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
            $datetime = Carbon::parse($this->reservation_date . ' ' . $this->reservation_time, 'Europe/Prague');
            
            $this->available_tables = $this->reservationService
                ->getAvailableTables($datetime, $this->party_size);
            
            // Don't automatically show tables, wait for user action
        }
    }

    public function nextStep()
    {
        if ($this->reservation_date && $this->reservation_time && $this->party_size) {
            $this->checkAvailability();
            $this->showTables = true;
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
            $datetime = Carbon::parse($this->reservation_date . ' ' . $this->reservation_time, 'Europe/Prague');
            
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
            if ($this->step === 1) {
                $this->showTables = false;
                $this->selected_table_id = null;
            }
        }
    }

    public function goToStep($targetStep)
    {
        if ($targetStep < $this->step) {
            // Reset data based on target step
            if ($targetStep === 1) {
                $this->showTables = false;
                $this->selected_table_id = null;
                $this->special_requests = '';
            } elseif ($targetStep === 2) {
                $this->selected_table_id = null;
                $this->special_requests = '';
            }
            
            $this->step = $targetStep;
        }
    }

    public function render()
    {
        return view('livewire.reservation-form');
    }
}