@extends('components.layouts.app')

@section('content')
<div class="min-h-screen">
    <!-- Hero Section -->
    <div class="bg-gradient-to-r from-amber-600 to-amber-800 text-white">
        <div class="max-w-7xl mx-auto px-4 py-20">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                <!-- Restaurant Info -->
                <div>
                    <h1 class="text-5xl font-bold mb-6">Welcome to Bella Vista</h1>
                    <p class="text-xl mb-8 text-amber-100">
                        Experience culinary excellence in an elegant atmosphere. Our award-winning chefs craft each dish 
                        with the finest ingredients and passion for perfection.
                    </p>
                    <div class="flex items-center space-x-6 text-amber-100">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"></path>
                            </svg>
                            <span>Downtown Location</span>
                        </div>
                        <div class="flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path>
                            </svg>
                            <span>Open Daily 5PM - 11PM</span>
                        </div>
                    </div>
                </div>

                <!-- Auth Section -->
                <div class="bg-white bg-opacity-10 backdrop-blur-lg rounded-lg p-8">
                    @auth
                        <!-- Quick Reservation for Authenticated Users -->
                        <h2 class="text-2xl font-bold mb-6">Make a Quick Reservation</h2>
                        <form action="/reserve" method="GET" class="space-y-4">
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium mb-2">Date</label>
                                    <input type="date" name="date" value="{{ date('Y-m-d', strtotime('+1 day')) }}" 
                                           class="w-full px-3 py-2 border border-amber-300 rounded-md text-gray-900 focus:outline-none focus:ring-2 focus:ring-amber-500">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium mb-2">Time</label>
                                    <select name="time" class="w-full px-3 py-2 border border-amber-300 rounded-md text-gray-900 focus:outline-none focus:ring-2 focus:ring-amber-500">
                                        <option value="17:00">5:00 PM</option>
                                        <option value="18:00">6:00 PM</option>
                                        <option value="19:00" selected>7:00 PM</option>
                                        <option value="20:00">8:00 PM</option>
                                        <option value="21:00">9:00 PM</option>
                                    </select>
                                </div>
                            </div>
                            <div>
                                <label class="block text-sm font-medium mb-2">Party Size</label>
                                <select name="party_size" class="w-full px-3 py-2 border border-amber-300 rounded-md text-gray-900 focus:outline-none focus:ring-2 focus:ring-amber-500">
                                    <option value="1">1 Person</option>
                                    <option value="2" selected>2 People</option>
                                    <option value="3">3 People</option>
                                    <option value="4">4 People</option>
                                    <option value="5">5 People</option>
                                    <option value="6">6 People</option>
                                    <option value="7">7 People</option>
                                    <option value="8">8+ People</option>
                                </select>
                            </div>
                            <button type="submit" class="w-full bg-amber-600 hover:bg-amber-700 text-white font-bold py-3 px-6 rounded-md transition duration-200">
                                Reserve Table
                            </button>
                        </form>
                        <div class="mt-4 text-center">
                            <a href="/my-reservations" class="text-amber-200 hover:text-white underline">View My Reservations</a>
                        </div>
                    @else
                        <!-- Login/Register for Guests -->
                        <h2 class="text-2xl font-bold mb-6">Join Us Today</h2>
                        <p class="mb-6 text-amber-100">Sign in to make reservations and manage your dining experience.</p>
                        <div class="space-y-4">
                            <a href="/login" class="block w-full bg-amber-600 hover:bg-amber-700 text-white font-bold py-3 px-6 rounded-md text-center transition duration-200">
                                Sign In
                            </a>
                            <a href="/register" class="block w-full bg-transparent border-2 border-white hover:bg-white hover:text-amber-800 text-white font-bold py-3 px-6 rounded-md text-center transition duration-200">
                                Create Account
                            </a>
                        </div>
                        <p class="mt-4 text-sm text-amber-200 text-center">
                            Already have an account? <a href="/login" class="underline hover:text-white">Sign in here</a>
                        </p>
                    @endauth
                </div>
            </div>
        </div>
    </div>

    <!-- Features Section -->
    <div class="py-20 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-bold text-gray-900 mb-4">Why Choose Bella Vista?</h2>
                <p class="text-xl text-gray-600">Experience the perfect blend of ambiance, cuisine, and service</p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="text-center">
                    <div class="bg-amber-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-6">
                        <svg class="w-8 h-8 text-amber-600" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-4">Award-Winning Cuisine</h3>
                    <p class="text-gray-600">Our head chef has won multiple culinary awards and creates innovative dishes using locally sourced ingredients.</p>
                </div>
                <div class="text-center">
                    <div class="bg-amber-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-6">
                        <svg class="w-8 h-8 text-amber-600" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-4">Easy Reservations</h3>
                    <p class="text-gray-600">Book your table online in seconds. Manage your reservations and receive confirmations instantly.</p>
                </div>
                <div class="text-center">
                    <div class="bg-amber-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-6">
                        <svg class="w-8 h-8 text-amber-600" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zM14 9a1 1 0 00-1 1v6a1 1 0 001 1h2a1 1 0 001-1v-6a1 1 0 00-1-1h-2z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-4">Elegant Atmosphere</h3>
                    <p class="text-gray-600">Enjoy intimate dining in our beautifully designed space, perfect for romantic dinners and special occasions.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Menu Preview Section -->
    <div class="py-20">
        <div class="max-w-7xl mx-auto px-4">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-bold text-gray-900 mb-4">Signature Dishes</h2>
                <p class="text-xl text-gray-600">A taste of what awaits you</p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                    <div class="h-48 bg-gradient-to-br from-amber-400 to-amber-600"></div>
                    <div class="p-6">
                        <h3 class="text-xl font-semibold text-gray-900 mb-2">Grilled Salmon</h3>
                        <p class="text-gray-600 mb-4">Fresh Atlantic salmon with lemon herb butter and seasonal vegetables</p>
                        <span class="text-2xl font-bold text-amber-600">$28</span>
                    </div>
                </div>
                <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                    <div class="h-48 bg-gradient-to-br from-red-400 to-red-600"></div>
                    <div class="p-6">
                        <h3 class="text-xl font-semibold text-gray-900 mb-2">Beef Tenderloin</h3>
                        <p class="text-gray-600 mb-4">Prime cut with truffle mashed potatoes and red wine reduction</p>
                        <span class="text-2xl font-bold text-amber-600">$42</span>
                    </div>
                </div>
                <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                    <div class="h-48 bg-gradient-to-br from-green-400 to-green-600"></div>
                    <div class="p-6">
                        <h3 class="text-xl font-semibold text-gray-900 mb-2">Pasta Primavera</h3>
                        <p class="text-gray-600 mb-4">House-made pasta with seasonal vegetables and parmesan cream sauce</p>
                        <span class="text-2xl font-bold text-amber-600">$22</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Call to Action -->
    <div class="bg-gray-900 text-white py-20">
        <div class="max-w-7xl mx-auto px-4 text-center">
            <h2 class="text-4xl font-bold mb-6">Ready to Dine With Us?</h2>
            <p class="text-xl text-gray-300 mb-8">Reserve your table today and experience culinary excellence</p>
            @auth
                <a href="/reserve" class="bg-amber-600 hover:bg-amber-700 text-white font-bold py-4 px-8 rounded-lg text-lg transition duration-200">
                    Make Reservation
                </a>
            @else
                <div class="space-x-4">
                    <a href="/register" class="bg-amber-600 hover:bg-amber-700 text-white font-bold py-4 px-8 rounded-lg text-lg transition duration-200">
                        Sign Up Now
                    </a>
                    <a href="/login" class="bg-transparent border-2 border-white hover:bg-white hover:text-gray-900 text-white font-bold py-4 px-8 rounded-lg text-lg transition duration-200">
                        Sign In
                    </a>
                </div>
            @endauth
        </div>
    </div>
</div>
@endsection
