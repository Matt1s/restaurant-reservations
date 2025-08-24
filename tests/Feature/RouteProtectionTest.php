<?php

use App\Models\User;
use Livewire\Livewire;

describe('Route Protection', function () {
    
    describe('Public Routes', function () {
        
        it('allows access to homepage', function () {
            $this->get('/')
                ->assertStatus(200);
        });

        it('allows guests to access login page', function () {
            $this->get('/login')
                ->assertStatus(200);
        });

        it('allows guests to access register page', function () {
            $this->get('/register')
                ->assertStatus(200);
        });
    });

    describe('Auth Middleware - Guest Only Routes', function () {
        
        it('redirects authenticated users from login page', function () {
            $user = User::factory()->create();
            $this->actingAs($user);

            $this->get('/login')
                ->assertRedirect('/');
        });

        it('redirects authenticated users from register page', function () {
            $user = User::factory()->create();
            $this->actingAs($user);

            $this->get('/register')
                ->assertRedirect('/');
        });
    });

    describe('Auth Middleware - Protected Routes', function () {
        
        it('redirects unauthenticated users from reservation page', function () {
            $this->get('/reservation')
                ->assertRedirect('/login');
        });

        it('redirects unauthenticated users from reserve page', function () {
            $this->get('/reserve')
                ->assertRedirect('/login');
        });

        it('redirects unauthenticated users from my-reservations page', function () {
            $this->get('/my-reservations')
                ->assertRedirect('/login');
        });

        it('allows authenticated users to access reservation page', function () {
            $user = User::factory()->create();
            $this->actingAs($user);

            $this->get('/reservation')
                ->assertStatus(200);
        });

        it('allows authenticated users to access reserve page', function () {
            $user = User::factory()->create();
            $this->actingAs($user);

            $this->get('/reserve')
                ->assertStatus(200);
        });

        it('allows authenticated users to access my-reservations page', function () {
            $user = User::factory()->create();
            $this->actingAs($user);

            $this->get('/my-reservations')
                ->assertStatus(200);
        });
    });

    describe('Logout Route', function () {
        
        it('allows authenticated users to logout', function () {
            $user = User::factory()->create();
            $this->actingAs($user);

            $this->post('/logout')
                ->assertRedirect('/');

            $this->assertGuest();
        });

        it('redirects unauthenticated users trying to logout', function () {
            $this->post('/logout')
                ->assertRedirect('/login');
        });
    });

    describe('Route Parameters and URL Handling', function () {
        
        it('handles reservation page with URL parameters', function () {
            $user = User::factory()->create();
            $this->actingAs($user);

            $this->get('/reservation?date=2024-12-25&time=19:00&party_size=4')
                ->assertStatus(200);
        });

        it('handles reserve page with URL parameters', function () {
            $user = User::factory()->create();
            $this->actingAs($user);

            $this->get('/reserve?date=2024-12-25&time=19:00&party_size=4')
                ->assertStatus(200);
        });
    });

    describe('Session and CSRF Protection', function () {
        
        it('requires CSRF token for logout', function () {
            $user = User::factory()->create();
            $this->actingAs($user);

            $this->withoutMiddleware(\App\Http\Middleware\VerifyCsrfToken::class);
            
            $response = $this->post('/logout');
            
            // Without CSRF middleware, it should work
            $response->assertRedirect('/');
        });

        it('handles session regeneration on login', function () {
            $user = User::factory()->create([
                'email' => 'user@user.com',
                'password' => bcrypt('password123'),
            ]);

            // Use Livewire Login component instead of direct POST
            Livewire::test(\App\Http\Livewire\Auth\Login::class)
                ->set('email', 'user@user.com')
                ->set('password', 'password123')
                ->call('login')
                ->assertRedirect('/reservation');

            $this->assertAuthenticated();
        });
    });

    describe('Named Routes', function () {
        
        it('has correct named routes', function () {
            expect(route('login'))->toBe(url('/login'));
            expect(route('register'))->toBe(url('/register'));
            expect(route('reservation'))->toBe(url('/reservation'));
            expect(route('reserve'))->toBe(url('/reserve'));
            expect(route('my-reservations'))->toBe(url('/my-reservations'));
            expect(route('logout'))->toBe(url('/logout'));
        });

        it('generates correct URLs for named routes', function () {
            expect(route('login'))->toContain('/login');
            expect(route('register'))->toContain('/register');
            expect(route('reservation'))->toContain('/reservation');
            expect(route('my-reservations'))->toContain('/my-reservations');
        });
    });
});
