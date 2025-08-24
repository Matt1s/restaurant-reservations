<?php

use App\Models\User;
use App\Models\Table;
use App\Models\Reservation;
use App\Services\ReservationService;
use Carbon\Carbon;

describe('ReservationService', function () {
    
    beforeEach(function () {
        $this->service = new ReservationService();
        $this->user = User::factory()->create();
        $this->table = Table::factory()->create(['capacity' => 4, 'is_active' => true]);
    });

    describe('getAvailableTables', function () {
        
        it('returns active tables with sufficient capacity', function () {
            $largeTable = Table::factory()->create(['capacity' => 8, 'is_active' => true]);
            $smallTable = Table::factory()->create(['capacity' => 2, 'is_active' => true]);
            $inactiveTable = Table::factory()->create(['capacity' => 6, 'is_active' => false]);
            
            $datetime = Carbon::tomorrow()->setTime(19, 0);
            $partySize = 4;
            
            $availableTables = $this->service->getAvailableTables($datetime, $partySize);
            
            // Should include tables with sufficient capacity
            expect($availableTables->pluck('id'))->toContain($this->table->id, $largeTable->id);
            
            // Should not include tables with insufficient capacity or inactive tables
            expect($availableTables->pluck('id'))->not->toContain($smallTable->id, $inactiveTable->id);
        });

        it('excludes tables with existing confirmed reservations', function () {
            $anotherTable = Table::factory()->create(['capacity' => 4, 'is_active' => true]);
            $datetime = Carbon::tomorrow()->setTime(19, 0);
            
            // Create existing reservation for one table
            Reservation::factory()->create([
                'table_id' => $this->table->id,
                'reservation_datetime' => $datetime,
                'status' => 'confirmed',
            ]);
            
            $availableTables = $this->service->getAvailableTables($datetime, 2);
            
            // Should not include table with existing reservation
            expect($availableTables->pluck('id'))->not->toContain($this->table->id);
            
            // Should include table without reservation
            expect($availableTables->pluck('id'))->toContain($anotherTable->id);
        });

        it('includes tables with cancelled reservations', function () {
            $datetime = Carbon::tomorrow()->setTime(19, 0);
            
            // Create cancelled reservation
            Reservation::factory()->create([
                'table_id' => $this->table->id,
                'reservation_datetime' => $datetime,
                'status' => 'cancelled',
            ]);
            
            $availableTables = $this->service->getAvailableTables($datetime, 2);
            
            // Should include table with cancelled reservation
            expect($availableTables->pluck('id'))->toContain($this->table->id);
        });

        it('handles multiple reservations at different times', function () {
            $datetime1 = Carbon::tomorrow()->setTime(18, 0);
            $datetime2 = Carbon::tomorrow()->setTime(19, 0);
            
            // Create reservation at 18:00
            Reservation::factory()->create([
                'table_id' => $this->table->id,
                'reservation_datetime' => $datetime1,
                'status' => 'confirmed',
            ]);
            
            // Table should still be available at 19:00
            $availableTables = $this->service->getAvailableTables($datetime2, 2);
            expect($availableTables->pluck('id'))->toContain($this->table->id);
        });
    });

    describe('createReservation', function () {
        
        it('creates a reservation with valid data', function () {
            $datetime = Carbon::tomorrow()->setTime(19, 0);
            
            $reservation = $this->service->createReservation(
                $this->user->id,
                $this->table->id,
                $datetime,
                2,
                'Window seat please'
            );
            
            expect($reservation)->toBeInstanceOf(Reservation::class);
            expect($reservation->user_id)->toBe($this->user->id);
            expect($reservation->table_id)->toBe($this->table->id);
            expect($reservation->party_size)->toBe(2);
            expect($reservation->special_requests)->toBe('Window seat please');
            expect($reservation->status)->toBe('confirmed');
            expect($reservation->reservation_datetime->toDateTimeString())
                ->toBe($datetime->toDateTimeString());
        });

        it('creates reservation without special requests', function () {
            $datetime = Carbon::tomorrow()->setTime(19, 0);
            
            $reservation = $this->service->createReservation(
                $this->user->id,
                $this->table->id,
                $datetime,
                2
            );
            
            expect($reservation->special_requests)->toBeNull();
        });

        it('throws exception when table is not available', function () {
            $datetime = Carbon::tomorrow()->setTime(19, 0);
            
            // Create existing reservation
            Reservation::factory()->create([
                'table_id' => $this->table->id,
                'reservation_datetime' => $datetime,
                'status' => 'confirmed',
            ]);
            
            expect(function () use ($datetime) {
                $this->service->createReservation(
                    $this->user->id,
                    $this->table->id,
                    $datetime,
                    2
                );
            })->toThrow(Exception::class, 'Table is not available at this time.');
        });

        it('throws exception when party size exceeds table capacity', function () {
            $datetime = Carbon::tomorrow()->setTime(19, 0);
            
            expect(function () use ($datetime) {
                $this->service->createReservation(
                    $this->user->id,
                    $this->table->id,
                    $datetime,
                    8 // Exceeds table capacity of 4
                );
            })->toThrow(Exception::class, 'Table capacity is insufficient for party size.');
        });

        it('throws exception for non-existent table', function () {
            $datetime = Carbon::tomorrow()->setTime(19, 0);
            
            expect(function () use ($datetime) {
                $this->service->createReservation(
                    $this->user->id,
                    999, // Non-existent table
                    $datetime,
                    2
                );
            })->toThrow(\Illuminate\Database\Eloquent\ModelNotFoundException::class);
        });

        it('throws exception for inactive table', function () {
            $inactiveTable = Table::factory()->create(['capacity' => 4, 'is_active' => false]);
            $datetime = Carbon::tomorrow()->setTime(19, 0);
            
            expect(function () use ($inactiveTable, $datetime) {
                $this->service->createReservation(
                    $this->user->id,
                    $inactiveTable->id,
                    $datetime,
                    2
                );
            })->toThrow(Exception::class, 'Table is not currently available for reservations.');
        });
    });

    describe('getTimeSlots', function () {
        
        it('returns time slots from 12:00 PM to 10:00 PM', function () {
            $date = Carbon::tomorrow()->format('Y-m-d');
            $timeSlots = $this->service->getTimeSlots($date);
            
            expect($timeSlots)->toBeArray();
            expect($timeSlots[0])->toBe('12:00');
            expect($timeSlots[count($timeSlots) - 1])->toBe('22:00');
        });

        it('returns slots at 30-minute intervals', function () {
            $date = Carbon::tomorrow()->format('Y-m-d');
            $timeSlots = $this->service->getTimeSlots($date);
            
            // Check that we have 30-minute intervals
            expect($timeSlots)->toContain('12:00', '12:30', '13:00', '13:30');
        });

        it('returns correct number of time slots', function () {
            $date = Carbon::tomorrow()->format('Y-m-d');
            $timeSlots = $this->service->getTimeSlots($date);
            
            // From 12:00 to 22:00 in 30-minute intervals = 21 slots
            expect(count($timeSlots))->toBe(21);
        });

        it('handles different date formats', function () {
            $date1 = Carbon::tomorrow()->format('Y-m-d');
            $date2 = Carbon::tomorrow();
            
            $timeSlots1 = $this->service->getTimeSlots($date1);
            $timeSlots2 = $this->service->getTimeSlots($date2);
            
            expect($timeSlots1)->toEqual($timeSlots2);
        });
    });
});
