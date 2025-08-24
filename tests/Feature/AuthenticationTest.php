<?php

use App\Models\User;
use Livewire\Livewire;
use App\Http\Livewire\Auth\Login;
use App\Http\Livewire\Auth\Register;

describe('Authentication', function () {
    
    describe('Registration', function () {
        
        it('can render the registration page', function () {
            $this->get('/register')
                ->assertStatus(200);
        });

        it('can register a new user with valid data', function () {
            Livewire::test(Register::class)
                ->set('name', 'John Doe')
                ->set('email', 'john@example.com')
                ->set('password', 'password123')
                ->set('password_confirmation', 'password123')
                ->call('register')
                ->assertRedirect('/reservation');

            $this->assertDatabaseHas('users', [
                'name' => 'John Doe',
                'email' => 'john@example.com',
            ]);

            $this->assertAuthenticated();
        });

        it('requires a name', function () {
            Livewire::test(Register::class)
                ->set('email', 'john@example.com')
                ->set('password', 'password123')
                ->set('password_confirmation', 'password123')
                ->call('register')
                ->assertHasErrors(['name' => 'required']);
        });

        it('requires a valid email', function () {
            Livewire::test(Register::class)
                ->set('name', 'John Doe')
                ->set('email', 'invalid-email')
                ->set('password', 'password123')
                ->set('password_confirmation', 'password123')
                ->call('register')
                ->assertHasErrors(['email' => 'email']);
        });

        it('requires a unique email', function () {
            User::factory()->create(['email' => 'john@example.com']);

            Livewire::test(Register::class)
                ->set('name', 'John Doe')
                ->set('email', 'john@example.com')
                ->set('password', 'password123')
                ->set('password_confirmation', 'password123')
                ->call('register')
                ->assertHasErrors(['email' => 'unique']);
        });

        it('requires password confirmation', function () {
            Livewire::test(Register::class)
                ->set('name', 'John Doe')
                ->set('email', 'john@example.com')
                ->set('password', 'password123')
                ->set('password_confirmation', 'different_password')
                ->call('register')
                ->assertHasErrors(['password' => 'confirmed']);
        });

        it('requires minimum password length', function () {
            Livewire::test(Register::class)
                ->set('name', 'John Doe')
                ->set('email', 'john@example.com')
                ->set('password', '123')
                ->set('password_confirmation', '123')
                ->call('register')
                ->assertHasErrors(['password' => 'min']);
        });

        it('redirects authenticated users away from registration page', function () {
            $user = User::factory()->create();
            $this->actingAs($user);

            $this->get('/register')
                ->assertRedirect('/');
        });
    });

    describe('Login', function () {
        
        it('can render the login page', function () {
            $this->get('/login')
                ->assertStatus(200);
        });

        it('can login with valid credentials', function () {
            $user = User::factory()->create([
                'email' => 'john@example.com',
                'password' => bcrypt('password123'),
            ]);

            Livewire::test(Login::class)
                ->set('email', 'john@example.com')
                ->set('password', 'password123')
                ->call('login')
                ->assertRedirect('/reservation');

            $this->assertAuthenticated();
            $this->assertAuthenticatedAs($user);
        });

        it('cannot login with invalid email', function () {
            Livewire::test(Login::class)
                ->set('email', 'nonexistent@example.com')
                ->set('password', 'password123')
                ->call('login')
                ->assertHasErrors(['email']);

            $this->assertGuest();
        });

        it('cannot login with invalid password', function () {
            $user = User::factory()->create([
                'email' => 'john@example.com',
                'password' => bcrypt('password123'),
            ]);

            Livewire::test(Login::class)
                ->set('email', 'john@example.com')
                ->set('password', 'wrong_password')
                ->call('login')
                ->assertHasErrors(['email']);

            $this->assertGuest();
        });

        it('requires an email', function () {
            Livewire::test(Login::class)
                ->set('password', 'password123')
                ->call('login')
                ->assertHasErrors(['email' => 'required']);
        });

        it('requires a valid email format', function () {
            Livewire::test(Login::class)
                ->set('email', 'invalid-email')
                ->set('password', 'password123')
                ->call('login')
                ->assertHasErrors(['email' => 'email']);
        });

        it('requires a password', function () {
            Livewire::test(Login::class)
                ->set('email', 'john@example.com')
                ->call('login')
                ->assertHasErrors(['password' => 'required']);
        });

        it('requires minimum password length', function () {
            Livewire::test(Login::class)
                ->set('email', 'john@example.com')
                ->set('password', '12345')
                ->call('login')
                ->assertHasErrors(['password' => 'min']);
        });

        it('can remember users when remember option is checked', function () {
            $user = User::factory()->create([
                'email' => 'john@example.com',
                'password' => bcrypt('password123'),
            ]);

            Livewire::test(Login::class)
                ->set('email', 'john@example.com')
                ->set('password', 'password123')
                ->set('remember', true)
                ->call('login')
                ->assertRedirect('/reservation');

            $this->assertAuthenticated();
        });

        it('redirects authenticated users away from login page', function () {
            $user = User::factory()->create();
            $this->actingAs($user);

            $this->get('/login')
                ->assertRedirect('/');
        });
    });

    describe('Logout', function () {
        
        it('can logout authenticated users', function () {
            $user = User::factory()->create();
            $this->actingAs($user);

            $this->post('/logout')
                ->assertRedirect('/');

            $this->assertGuest();
        });

        it('cannot logout unauthenticated users', function () {
            $this->post('/logout')
                ->assertRedirect('/login');
        });
    });
});
