<?php

use App\Models\User;
use App\Models\Table;
use App\Models\Reservation;
use Livewire\Livewire;
use App\Http\Livewire\Auth\Register;
use App\Http\Livewire\Auth\Login;
use App\Http\Livewire\ReservationForm;
use App\Http\Livewire\MyReservations;
use Carbon\Carbon;

describe('Integration Tests', function () {
    
    describe('Complete User Journey', function () {
        
        it('can complete full registration to reservation flow', function () {
            // Create a table for reservation
            $table = Table::factory()->create(['capacity' => 4, 'is_active' => true]);
            
            // Step 1: Register a new user
            Livewire::test(Register::class)
                ->set('name', 'John Doe')
                ->set('email', 'john@example.com')
                ->set('password', 'password123')
                ->set('password_confirmation', 'password123')
                ->call('register')
                ->assertRedirect('/reservation');
            
            // Verify user was created and authenticated
            $this->assertAuthenticated();
            $user = User::where('email', 'john@example.com')->first();
            expect($user)->not->toBeNull();
            expect($user->name)->toBe('John Doe');
            
            // Step 2: Make a reservation
            $reservationDate = Carbon::tomorrow()->format('Y-m-d');
            
            $this->actingAs($user);
            
            Livewire::test(ReservationForm::class)
                ->set('reservation_date', $reservationDate)
                ->set('reservation_time', '19:00')
                ->set('party_size', 2)
                ->call('nextStep')
                ->assertSet('step', 2)
                ->call('selectTable', $table->id)
                ->assertSet('step', 3)
                ->set('special_requests', 'Birthday celebration')
                ->call('makeReservation')
                ->assertRedirect('/my-reservations');
            
            // Verify reservation was created
            $this->assertDatabaseHas('reservations', [
                'user_id' => $user->id,
                'table_id' => $table->id,
                'party_size' => 2,
                'special_requests' => 'Birthday celebration',
                'status' => 'pending',
            ]);
            
            // Step 3: View reservations
            Livewire::test(MyReservations::class)
                ->assertSee('Table'); // Should see the table information
        });

        it('can handle login and immediate reservation', function () {
            // Create user and table
            $user = User::factory()->create([
                'email' => 'existing@example.com',
                'password' => bcrypt('password123'),
            ]);
            $table = Table::factory()->create(['capacity' => 4, 'is_active' => true]);
            
            // Step 1: Login
            Livewire::test(Login::class)
                ->set('email', 'existing@example.com')
                ->set('password', 'password123')
                ->call('login')
                ->assertRedirect('/reservation');
            
            $this->assertAuthenticated();
            
            // Step 2: Make reservation immediately after login
            $this->actingAs($user);
            
            Livewire::test(ReservationForm::class)
                ->set('reservation_date', Carbon::tomorrow()->format('Y-m-d'))
                ->set('reservation_time', '20:00')
                ->set('party_size', 4)
                ->call('checkAvailability')
                ->call('nextStep')
                ->call('selectTable', $table->id)
                ->call('makeReservation')
                ->assertRedirect('/my-reservations');
            
            // Verify reservation
            expect(Reservation::where('user_id', $user->id)->count())->toBe(1);
        });

        it('handles homepage to reservation flow with URL parameters', function () {
            $user = User::factory()->create();
            $table = Table::factory()->create(['capacity' => 6, 'is_active' => true]);
            
            $this->actingAs($user);
            
            // Simulate coming from homepage with parameters
            $validDate = Carbon::tomorrow()->format('Y-m-d');
            
            $this->get('/reservation?date=' . $validDate . '&time=18:00&party_size=6')
                ->assertStatus(200);
            
            // The page should load successfully with parameters
        });
    });

    describe('Error Handling and Edge Cases', function () {
        
        it('handles table becoming unavailable during reservation process', function () {
            $user = User::factory()->create();
            $table = Table::factory()->create(['capacity' => 4, 'is_active' => true]);
            $anotherUser = User::factory()->create();
            
            $this->actingAs($user);
            
            $datetime = Carbon::tomorrow()->setTime(19, 0);
            
            // Start reservation process
            $component = Livewire::test(ReservationForm::class)
                ->set('reservation_date', $datetime->format('Y-m-d'))
                ->set('reservation_time', $datetime->format('H:i'))
                ->set('party_size', 2)
                ->call('nextStep')
                ->call('selectTable', $table->id);
            
            // Another user books the same table
            Reservation::factory()->create([
                'user_id' => $anotherUser->id,
                'table_id' => $table->id,
                'reservation_datetime' => $datetime,
                'status' => 'confirmed',
            ]);
            
            // Try to complete reservation - should fail
            $component
                ->call('makeReservation')
                ->assertHasErrors(['general']);
        });

        it('handles invalid URL parameters gracefully', function () {
            $user = User::factory()->create();
            $this->actingAs($user);
            
            // Test accessing with invalid URL parameters
            $this->get('/reservation?date=invalid-date&time=25:00&party_size=15')
                ->assertStatus(200);
            
            // Should render the page successfully despite invalid parameters
        });

        it('handles table deactivation during reservation process', function () {
            $user = User::factory()->create();
            $table = Table::factory()->create(['capacity' => 4, 'is_active' => true]);
            
            $this->actingAs($user);
            
            // Start reservation process
            $component = Livewire::test(ReservationForm::class)
                ->set('reservation_date', Carbon::tomorrow()->format('Y-m-d'))
                ->set('reservation_time', '19:00')
                ->set('party_size', 2)
                ->call('nextStep')
                ->call('selectTable', $table->id);
            
            // Deactivate the table
            $table->update(['is_active' => false]);
            
            // Try to complete reservation - should fail
            $component
                ->call('makeReservation')
                ->assertHasErrors(['general']);
        });
    });

    describe('Multi-Step Form Flow', function () {
        
        it('can navigate backwards through form steps', function () {
            $user = User::factory()->create();
            $table = Table::factory()->create(['capacity' => 4, 'is_active' => true]);
            
            $this->actingAs($user);
            
            $component = Livewire::test(ReservationForm::class)
                ->set('reservation_date', Carbon::tomorrow()->format('Y-m-d'))
                ->set('reservation_time', '19:00')
                ->set('party_size', 2)
                ->call('nextStep')
                ->assertSet('step', 2)
                ->call('selectTable', $table->id)
                ->assertSet('step', 3)
                ->call('goBack')
                ->assertSet('step', 2)
                ->call('goBack')
                ->assertSet('step', 1);
        });

        it('resets appropriate data when going back', function () {
            $user = User::factory()->create();
            $table = Table::factory()->create(['capacity' => 4, 'is_active' => true]);
            
            $this->actingAs($user);
            
            $component = Livewire::test(ReservationForm::class)
                ->set('reservation_date', Carbon::tomorrow()->format('Y-m-d'))
                ->set('reservation_time', '19:00')
                ->set('party_size', 2)
                ->call('nextStep')
                ->call('selectTable', $table->id)
                ->set('special_requests', 'Window seat')
                ->call('goToStep', 1)
                ->assertSet('step', 1)
                ->assertSet('showTables', false)
                ->assertSet('selected_table_id', null)
                ->assertSet('special_requests', '');
        });

        it('updates available tables when form data changes', function () {
            $user = User::factory()->create();
            $smallTable = Table::factory()->create(['capacity' => 2, 'is_active' => true]);
            $largeTable = Table::factory()->create(['capacity' => 8, 'is_active' => true]);
            
            $this->actingAs($user);
            
            $component = Livewire::test(ReservationForm::class)
                ->set('reservation_date', Carbon::tomorrow()->format('Y-m-d'))
                ->set('reservation_time', '19:00')
                ->set('party_size', 2)
                ->call('checkAvailability');
            
            $availableTables = $component->get('available_tables');
            expect($availableTables->pluck('id'))->toContain($smallTable->id, $largeTable->id);
            
            // Change party size to 6
            $component->set('party_size', 6)
                ->call('checkAvailability');
            
            $availableTables = $component->get('available_tables');
            expect($availableTables->pluck('id'))->toContain($largeTable->id);
            expect($availableTables->pluck('id'))->not->toContain($smallTable->id);
        });
    });

    describe('User Experience Flow', function () {
        
        it('maintains form state across livewire updates', function () {
            $user = User::factory()->create();
            $this->actingAs($user);
            
            $component = Livewire::test(ReservationForm::class)
                ->set('reservation_date', Carbon::tomorrow()->format('Y-m-d'))
                ->set('reservation_time', '19:00')
                ->set('party_size', 4)
                ->set('special_requests', 'Birthday party');
            
            // Update one field - others should remain
            $component->set('party_size', 6);
            
            expect($component->get('reservation_date'))->toBe(Carbon::tomorrow()->format('Y-m-d'));
            expect($component->get('reservation_time'))->toBe('19:00');
            expect($component->get('party_size'))->toBe(6);
            expect($component->get('special_requests'))->toBe('Birthday party');
        });

        it('provides feedback for successful operations', function () {
            $user = User::factory()->create();
            $table = Table::factory()->create(['capacity' => 4, 'is_active' => true]);
            
            $this->actingAs($user);
            
            Livewire::test(ReservationForm::class)
                ->set('reservation_date', Carbon::tomorrow()->format('Y-m-d'))
                ->set('reservation_time', '19:00')
                ->set('party_size', 2)
                ->call('nextStep')
                ->call('selectTable', $table->id)
                ->call('makeReservation')
                ->assertRedirect('/my-reservations');
            
            expect(session('message'))->toBe('Reservation created successfully!');
        });
    });
});
