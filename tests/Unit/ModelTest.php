<?php

use App\Models\User;
use App\Models\Table;
use App\Models\Reservation;
use Carbon\Carbon;

describe('Models', function () {
    
    describe('User Model', function () {
        
        it('can create a user', function () {
            $user = User::factory()->create([
                'name' => 'John Doe',
                'email' => 'john@example.com',
            ]);
            
            expect($user->name)->toBe('John Doe');
            expect($user->email)->toBe('john@example.com');
            expect($user->password)->not->toBeNull();
        });

        it('hashes password automatically', function () {
            $user = User::factory()->create(['password' => 'plaintext']);
            
            expect($user->password)->not->toBe('plaintext');
            expect(strlen($user->password))->toBeGreaterThan(50); // Hashed passwords are longer
        });

        it('has many reservations relationship', function () {
            $user = User::factory()->create();
            $table = Table::factory()->create();
            
            Reservation::factory(3)->create([
                'user_id' => $user->id,
                'table_id' => $table->id,
            ]);
            
            expect($user->reservations)->toHaveCount(3);
            expect($user->reservations->first())->toBeInstanceOf(Reservation::class);
        });

        it('has fillable attributes', function () {
            $fillable = (new User())->getFillable();
            
            expect($fillable)->toContain('name', 'email', 'password');
        });

        it('has hidden attributes', function () {
            $hidden = (new User())->getHidden();
            
            expect($hidden)->toContain('password', 'remember_token');
        });

        it('casts email_verified_at to datetime', function () {
            $user = User::factory()->create([
                'email_verified_at' => '2024-01-01 12:00:00',
            ]);
            
            expect($user->email_verified_at)->toBeInstanceOf(Carbon::class);
        });
    });

    describe('Table Model', function () {
        
        it('can create a table', function () {
            $table = Table::factory()->create([
                'name' => 'Table 1',
                'capacity' => 4,
                'is_active' => true,
            ]);
            
            expect($table->name)->toBe('Table 1');
            expect($table->capacity)->toBe(4);
            expect($table->is_active)->toBeTrue();
        });

        it('has many reservations relationship', function () {
            $table = Table::factory()->create();
            $user = User::factory()->create();
            
            Reservation::factory(2)->create([
                'table_id' => $table->id,
                'user_id' => $user->id,
            ]);
            
            expect($table->reservations)->toHaveCount(2);
            expect($table->reservations->first())->toBeInstanceOf(Reservation::class);
        });

        it('casts is_active to boolean', function () {
            $table = Table::factory()->create(['is_active' => 1]);
            
            expect($table->is_active)->toBeTrue();
            expect($table->is_active)->toBeBool();
        });

        it('has fillable attributes', function () {
            $fillable = (new Table())->getFillable();
            
            expect($fillable)->toContain('name', 'capacity', 'is_active');
        });

        describe('isAvailableAt method', function () {
            
            it('returns true when no confirmed reservations exist', function () {
                $table = Table::factory()->create();
                $datetime = Carbon::tomorrow()->setTime(19, 0);
                
                expect($table->isAvailableAt($datetime))->toBeTrue();
            });

            it('returns false when confirmed reservation exists', function () {
                $table = Table::factory()->create();
                $user = User::factory()->create();
                $datetime = Carbon::tomorrow()->setTime(19, 0);
                
                Reservation::factory()->create([
                    'table_id' => $table->id,
                    'user_id' => $user->id,
                    'reservation_datetime' => $datetime,
                    'status' => 'confirmed',
                ]);
                
                expect($table->isAvailableAt($datetime))->toBeFalse();
            });

            it('returns true when only cancelled reservations exist', function () {
                $table = Table::factory()->create();
                $user = User::factory()->create();
                $datetime = Carbon::tomorrow()->setTime(19, 0);
                
                Reservation::factory()->create([
                    'table_id' => $table->id,
                    'user_id' => $user->id,
                    'reservation_datetime' => $datetime,
                    'status' => 'cancelled',
                ]);
                
                expect($table->isAvailableAt($datetime))->toBeTrue();
            });

            it('handles different datetime at same table', function () {
                $table = Table::factory()->create();
                $user = User::factory()->create();
                $datetime1 = Carbon::tomorrow()->setTime(18, 0);
                $datetime2 = Carbon::tomorrow()->setTime(19, 0);
                
                Reservation::factory()->create([
                    'table_id' => $table->id,
                    'user_id' => $user->id,
                    'reservation_datetime' => $datetime1,
                    'status' => 'confirmed',
                ]);
                
                expect($table->isAvailableAt($datetime1))->toBeFalse();
                expect($table->isAvailableAt($datetime2))->toBeTrue();
            });
        });
    });

    describe('Reservation Model', function () {
        
        it('can create a reservation', function () {
            $user = User::factory()->create();
            $table = Table::factory()->create();
            $datetime = Carbon::tomorrow()->setTime(19, 0);
            
            $reservation = Reservation::factory()->create([
                'user_id' => $user->id,
                'table_id' => $table->id,
                'reservation_datetime' => $datetime,
                'party_size' => 4,
                'special_requests' => 'Window seat',
                'status' => 'confirmed',
            ]);
            
            expect($reservation->user_id)->toBe($user->id);
            expect($reservation->table_id)->toBe($table->id);
            expect($reservation->party_size)->toBe(4);
            expect($reservation->special_requests)->toBe('Window seat');
            expect($reservation->status)->toBe('confirmed');
        });

        it('belongs to user', function () {
            $user = User::factory()->create();
            $table = Table::factory()->create();
            
            $reservation = Reservation::factory()->create([
                'user_id' => $user->id,
                'table_id' => $table->id,
            ]);
            
            expect($reservation->user)->toBeInstanceOf(User::class);
            expect($reservation->user->id)->toBe($user->id);
        });

        it('belongs to table', function () {
            $user = User::factory()->create();
            $table = Table::factory()->create();
            
            $reservation = Reservation::factory()->create([
                'user_id' => $user->id,
                'table_id' => $table->id,
            ]);
            
            expect($reservation->table)->toBeInstanceOf(Table::class);
            expect($reservation->table->id)->toBe($table->id);
        });

        it('casts reservation_datetime to Carbon instance', function () {
            $user = User::factory()->create();
            $table = Table::factory()->create();
            
            $reservation = Reservation::factory()->create([
                'user_id' => $user->id,
                'table_id' => $table->id,
                'reservation_datetime' => '2024-12-25 19:00:00',
            ]);
            
            expect($reservation->reservation_datetime)->toBeInstanceOf(Carbon::class);
        });

        it('has fillable attributes', function () {
            $fillable = (new Reservation())->getFillable();
            
            expect($fillable)->toContain(
                'user_id',
                'table_id',
                'reservation_datetime',
                'party_size',
                'special_requests',
                'status'
            );
        });

        describe('canBeCancelled method', function () {
            
            it('returns true for confirmed future reservations', function () {
                $user = User::factory()->create();
                $table = Table::factory()->create();
                
                $reservation = Reservation::factory()->create([
                    'user_id' => $user->id,
                    'table_id' => $table->id,
                    'reservation_datetime' => Carbon::now()->addDays(1),
                    'status' => 'confirmed',
                ]);
                
                expect($reservation->canBeCancelled())->toBeTrue();
            });

            it('returns false for cancelled reservations', function () {
                $user = User::factory()->create();
                $table = Table::factory()->create();
                
                $reservation = Reservation::factory()->create([
                    'user_id' => $user->id,
                    'table_id' => $table->id,
                    'reservation_datetime' => Carbon::now()->addDays(1),
                    'status' => 'cancelled',
                ]);
                
                expect($reservation->canBeCancelled())->toBeFalse();
            });

            it('returns false for reservations within 2 hours', function () {
                $user = User::factory()->create();
                $table = Table::factory()->create();
                
                $reservation = Reservation::factory()->create([
                    'user_id' => $user->id,
                    'table_id' => $table->id,
                    'reservation_datetime' => Carbon::now()->addHour(),
                    'status' => 'confirmed',
                ]);
                
                expect($reservation->canBeCancelled())->toBeFalse();
            });

            it('returns true for reservations exactly 2 hours and 1 minute away', function () {
                $user = User::factory()->create();
                $table = Table::factory()->create();
                
                $reservation = Reservation::factory()->create([
                    'user_id' => $user->id,
                    'table_id' => $table->id,
                    'reservation_datetime' => Carbon::now()->addHours(2)->addMinute(),
                    'status' => 'confirmed',
                ]);
                
                expect($reservation->canBeCancelled())->toBeTrue();
            });

            it('returns false for past reservations', function () {
                $user = User::factory()->create();
                $table = Table::factory()->create();
                
                $reservation = Reservation::factory()->create([
                    'user_id' => $user->id,
                    'table_id' => $table->id,
                    'reservation_datetime' => Carbon::now()->subDay(),
                    'status' => 'confirmed',
                ]);
                
                expect($reservation->canBeCancelled())->toBeFalse();
            });
        });
    });
});
