<?php

use App\Models\User;
use App\Models\Table;
use App\Models\Reservation;
use App\Services\ReservationService;
use Livewire\Livewire;
use App\Http\Livewire\ReservationForm;
use App\Http\Livewire\MyReservations;
use Carbon\Carbon;

describe('Reservations', function () {
    
    beforeEach(function () {
        $this->user = User::factory()->create();
        $this->table = Table::factory()->create(['capacity' => 4, 'is_active' => true]);
        $this->reservationService = app(ReservationService::class);
    });

    describe('Reservation Creation', function () {
        
        it('allows authenticated users to access reservation form', function () {
            $this->actingAs($this->user);
            
            $this->get('/reservation')
                ->assertStatus(200);
        });

        it('redirects unauthenticated users to login', function () {
            $this->get('/reservation')
                ->assertRedirect('/login');
        });

        it('can create a reservation with valid data', function () {
            $this->actingAs($this->user);
            
            $reservationDate = Carbon::tomorrow()->format('Y-m-d');
            $reservationTime = '19:00';
            
            Livewire::test(ReservationForm::class)
                ->set('reservation_date', $reservationDate)
                ->set('reservation_time', $reservationTime)
                ->set('party_size', 2)
                ->set('selected_table_id', $this->table->id)
                ->set('special_requests', 'Window seat please')
                ->call('makeReservation')
                ->assertRedirect('/my-reservations');

            $this->assertDatabaseHas('reservations', [
                'user_id' => $this->user->id,
                'table_id' => $this->table->id,
                'party_size' => 2,
                'special_requests' => 'Window seat please',
                'status' => 'pending',
            ]);
        });

        it('creates reservation with correct datetime', function () {
            $this->actingAs($this->user);
            
            $reservationDate = Carbon::tomorrow()->format('Y-m-d');
            $reservationTime = '19:00';
            $expectedDatetime = Carbon::parse($reservationDate . ' ' . $reservationTime);
            
            Livewire::test(ReservationForm::class)
                ->set('reservation_date', $reservationDate)
                ->set('reservation_time', $reservationTime)
                ->set('party_size', 2)
                ->set('selected_table_id', $this->table->id)
                ->call('makeReservation');

            $reservation = Reservation::first();
            expect($reservation->reservation_datetime->toDateTimeString())
                ->toBe($expectedDatetime->toDateTimeString());
        });

        it('prevents double booking of same table at same time', function () {
            $this->actingAs($this->user);
            
            $datetime = Carbon::tomorrow()->setTime(19, 0);
            
            // Create existing reservation
            Reservation::factory()->create([
                'table_id' => $this->table->id,
                'reservation_datetime' => $datetime,
                'status' => 'confirmed',
            ]);

            Livewire::test(ReservationForm::class)
                ->set('reservation_date', $datetime->format('Y-m-d'))
                ->set('reservation_time', $datetime->format('H:i'))
                ->set('party_size', 2)
                ->set('selected_table_id', $this->table->id)
                ->call('makeReservation')
                ->assertHasErrors(['general']);
        });

        it('prevents reservation if party size exceeds table capacity', function () {
            $this->actingAs($this->user);
            
            $smallTable = Table::factory()->create(['capacity' => 2, 'is_active' => true]);
            
            Livewire::test(ReservationForm::class)
                ->set('reservation_date', Carbon::tomorrow()->format('Y-m-d'))
                ->set('reservation_time', '19:00')
                ->set('party_size', 4) // Exceeds table capacity of 2
                ->set('selected_table_id', $smallTable->id)
                ->call('makeReservation')
                ->assertHasErrors(['general']);
        });

        it('shows available tables based on party size and datetime', function () {
            $this->actingAs($this->user);
            
            $largeTable = Table::factory()->create(['capacity' => 8, 'is_active' => true]);
            $smallTable = Table::factory()->create(['capacity' => 2, 'is_active' => true]);
            
            $component = Livewire::test(ReservationForm::class)
                ->set('reservation_date', Carbon::tomorrow()->format('Y-m-d'))
                ->set('reservation_time', '19:00')
                ->set('party_size', 4)
                ->call('checkAvailability');

            $availableTables = $component->get('available_tables');
            
            // Should include tables with sufficient capacity
            expect($availableTables->pluck('id'))->toContain($this->table->id, $largeTable->id);
            // Should not include tables with insufficient capacity
            expect($availableTables->pluck('id'))->not->toContain($smallTable->id);
        });

        it('excludes inactive tables from availability', function () {
            $this->actingAs($this->user);
            
            $inactiveTable = Table::factory()->create(['capacity' => 4, 'is_active' => false]);
            
            $component = Livewire::test(ReservationForm::class)
                ->set('reservation_date', Carbon::tomorrow()->format('Y-m-d'))
                ->set('reservation_time', '19:00')
                ->set('party_size', 2)
                ->call('checkAvailability');

            $availableTables = $component->get('available_tables');
            
            expect($availableTables->pluck('id'))->not->toContain($inactiveTable->id);
        });
    });

    describe('Reservation Form Flow', function () {
        
        it('starts at step 1 by default', function () {
            $this->actingAs($this->user);
            
            $component = Livewire::test(ReservationForm::class);
            expect($component->get('step'))->toBe(1);
        });

        it('advances to step 2 when nextStep is called with valid data', function () {
            $this->actingAs($this->user);
            
            Livewire::test(ReservationForm::class)
                ->set('reservation_date', Carbon::tomorrow()->format('Y-m-d'))
                ->set('reservation_time', '19:00')
                ->set('party_size', 2)
                ->call('nextStep')
                ->assertSet('step', 2)
                ->assertSet('showTables', true);
        });

        it('does not advance step without required data', function () {
            $this->actingAs($this->user);
            
            Livewire::test(ReservationForm::class)
                ->call('nextStep')
                ->assertSet('step', 1);
        });

        it('advances to step 3 when table is selected', function () {
            $this->actingAs($this->user);
            
            Livewire::test(ReservationForm::class)
                ->set('step', 2)
                ->call('selectTable', $this->table->id)
                ->assertSet('step', 3)
                ->assertSet('selected_table_id', $this->table->id);
        });

        it('can go back to previous steps', function () {
            $this->actingAs($this->user);
            
            Livewire::test(ReservationForm::class)
                ->set('step', 3)
                ->call('goBack')
                ->assertSet('step', 2);
        });

        it('can jump to specific step when going backwards', function () {
            $this->actingAs($this->user);
            
            Livewire::test(ReservationForm::class)
                ->set('step', 3)
                ->set('selected_table_id', $this->table->id)
                ->call('goToStep', 1)
                ->assertSet('step', 1)
                ->assertSet('showTables', false)
                ->assertSet('selected_table_id', null);
        });

        it('processes URL parameters correctly on mount', function () {
            $this->actingAs($this->user);
            
            $validDate = Carbon::tomorrow()->format('Y-m-d');
            
            // Test URL parameters through HTTP request
            $this->get('/reservation?date=' . $validDate . '&time=19:00&party_size=4')
                ->assertStatus(200);
        });
    });

    describe('My Reservations', function () {
        
        it('allows authenticated users to view their reservations', function () {
            $this->actingAs($this->user);
            
            $this->get('/my-reservations')
                ->assertStatus(200);
        });

        it('redirects unauthenticated users to login', function () {
            $this->get('/my-reservations')
                ->assertRedirect('/login');
        });

        it('shows only user\'s own reservations', function () {
            $this->actingAs($this->user);
            
            $otherUser = User::factory()->create();
            
            // Create reservations for current user
            $userReservation = Reservation::factory()->create([
                'user_id' => $this->user->id,
                'table_id' => $this->table->id,
                'reservation_datetime' => Carbon::tomorrow()->setTime(19, 0),
            ]);
            
            // Create reservation for other user
            Reservation::factory()->create([
                'user_id' => $otherUser->id,
                'table_id' => $this->table->id,
                'reservation_datetime' => Carbon::tomorrow()->setTime(20, 0),
            ]);
            
            $component = Livewire::test(MyReservations::class);
            
            // Should see own reservation table name
            $component->assertSee($userReservation->table->name);
        });
    });

    describe('Reservation Cancellation', function () {
        
        it('allows cancellation of future reservations', function () {
            $this->actingAs($this->user);
            
            $futureReservation = Reservation::factory()->create([
                'user_id' => $this->user->id,
                'table_id' => $this->table->id,
                'reservation_datetime' => Carbon::now()->addDays(2),
                'status' => 'confirmed',
            ]);
            
            expect($futureReservation->canBeCancelled())->toBeTrue();
        });

        it('prevents cancellation of reservations within 2 hours', function () {
            $this->actingAs($this->user);
            
            $soonReservation = Reservation::factory()->create([
                'user_id' => $this->user->id,
                'table_id' => $this->table->id,
                'reservation_datetime' => Carbon::now()->addHour(),
                'status' => 'confirmed',
            ]);
            
            expect($soonReservation->canBeCancelled())->toBeFalse();
        });

        it('prevents cancellation of already cancelled reservations', function () {
            $this->actingAs($this->user);
            
            $cancelledReservation = Reservation::factory()->create([
                'user_id' => $this->user->id,
                'table_id' => $this->table->id,
                'reservation_datetime' => Carbon::now()->addDays(2),
                'status' => 'cancelled',
            ]);
            
            expect($cancelledReservation->canBeCancelled())->toBeFalse();
        });
    });
});
