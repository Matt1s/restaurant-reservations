<div class="min-h-screen bg-gray-50">
    <!-- Header Section -->
    <div class="bg-gradient-to-r from-red-600 to-red-700 text-white">
        <div class="max-w-7xl mx-auto px-4 py-16">
            <div class="text-center">
                <h1 class="text-4xl font-bold mb-4">Admin Dashboard</h1>
                <p class="text-xl text-red-100">Manage all restaurant reservations with ease</p>
            </div>
        </div>
    </div>

    <!-- Flash messages -->
    @if (session()->has('message'))
        <div class="max-w-7xl mx-auto px-4 mt-6">
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg relative shadow-md" role="alert">
                <div class="flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                    </svg>
                    <span class="block sm:inline">{{ session('message') }}</span>
                </div>
            </div>
        </div>
    @endif

    <!-- Content Section -->
    <div class="max-w-7xl mx-auto px-4 py-12">
        <!-- Stats Section -->
        <div class="grid grid-cols-1 gap-5 sm:grid-cols-3 mb-12">
            <!-- Pending Stats -->
            <div class="bg-white overflow-hidden shadow-lg rounded-lg hover:shadow-xl transition-shadow duration-300">
                <div class="p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-12 h-12 bg-yellow-500 rounded-full flex items-center justify-center">
                                <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M10 2a8 8 0 100 16 8 8 0 000-16zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">Pending Approval</dt>
                                <dd class="text-3xl font-bold text-gray-900">{{ $stats['pending'] }}</dd>
                                <dd class="text-sm text-yellow-600">Requires Action</dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Confirmed Stats -->
            <div class="bg-white overflow-hidden shadow-lg rounded-lg hover:shadow-xl transition-shadow duration-300">
                <div class="p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-12 h-12 bg-green-500 rounded-full flex items-center justify-center">
                                <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">Confirmed Reservations</dt>
                                <dd class="text-3xl font-bold text-gray-900">{{ $stats['confirmed'] }}</dd>
                                <dd class="text-sm text-green-600">Active Bookings</dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Cancelled Stats -->
            <div class="bg-white overflow-hidden shadow-lg rounded-lg hover:shadow-xl transition-shadow duration-300">
                <div class="p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-12 h-12 bg-red-500 rounded-full flex items-center justify-center">
                                <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">Cancelled Reservations</dt>
                                <dd class="text-3xl font-bold text-gray-900">{{ $stats['cancelled'] }}</dd>
                                <dd class="text-sm text-red-600">No Longer Active</dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @if($reservations->count() > 0)
            <!-- Reservations Grid -->
            <div class="grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-3 gap-8">
                @foreach($reservations as $reservation)
                    <div class="bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition-shadow duration-300">
                        <!-- Status Header -->
                        <div class="px-6 py-4 
                            @if($reservation->status === 'confirmed') bg-green-500
                            @elseif($reservation->status === 'pending') bg-yellow-500
                            @elseif($reservation->status === 'cancelled') bg-red-500
                            @else bg-gray-500 @endif">
                            <div class="flex items-center justify-between">
                                <span class="text-white font-semibold text-lg">
                                    {{ ucfirst($reservation->status) }}
                                </span>
                                <div class="text-white text-sm">
                                    #{{ $reservation->id }}
                                </div>
                            </div>
                        </div>

                        <!-- Reservation Details -->
                        <div class="p-6">
                            <!-- Customer Info -->
                            <div class="mb-4">
                                <div class="flex items-center text-gray-700 mb-2">
                                    <svg class="w-5 h-5 mr-3 text-red-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                                    </svg>
                                    <div>
                                        <div class="font-semibold text-lg text-gray-900">
                                            {{ $reservation->user->name }}
                                        </div>
                                        <div class="text-gray-600 text-sm">
                                            {{ $reservation->user->email }}
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Date and Time -->
                            <div class="mb-4">
                                <div class="flex items-center text-gray-700 mb-2">
                                    <svg class="w-5 h-5 mr-3 text-red-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path>
                                    </svg>
                                    <div>
                                        <div class="font-semibold text-gray-900">
                                            {{ $reservation->reservation_datetime->format('M j, Y') }}
                                        </div>
                                        <div class="text-gray-600">
                                            {{ $reservation->reservation_datetime->format('g:i A') }}
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Table and Party Size -->
                            <div class="grid grid-cols-2 gap-4 mb-4">
                                <div class="flex items-center text-gray-700">
                                    <svg class="w-5 h-5 mr-3 text-red-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zM14 9a1 1 0 00-1 1v6a1 1 0 001 1h2a1 1 0 001-1v-6a1 1 0 00-1-1h-2z"></path>
                                    </svg>
                                    <div>
                                        <div class="text-sm text-gray-500">Table</div>
                                        <div class="font-semibold">{{ $reservation->table->name ?? 'N/A' }}</div>
                                    </div>
                                </div>
                                <div class="flex items-center text-gray-700">
                                    <svg class="w-5 h-5 mr-3 text-red-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z"></path>
                                    </svg>
                                    <div>
                                        <div class="text-sm text-gray-500">Party Size</div>
                                        <div class="font-semibold">{{ $reservation->party_size }} {{ $reservation->party_size == 1 ? 'person' : 'people' }}</div>
                                    </div>
                                </div>
                            </div>

                            <!-- Special Requests -->
                            @if($reservation->special_requests)
                                <div class="mb-4 p-3 bg-gray-50 rounded-md">
                                    <div class="text-sm text-gray-500 mb-1">Special Requests</div>
                                    <div class="text-gray-700">{{ $reservation->special_requests }}</div>
                                </div>
                            @endif

                            <!-- Admin Actions -->
                            <div class="mt-6 space-y-2">
                                @if($reservation->status === 'pending')
                                    <button wire:click="confirmReservation({{ $reservation->id }})"
                                            class="w-full bg-green-600 hover:bg-green-700 text-white font-bold py-3 px-4 rounded-md transition duration-200 flex items-center justify-center">
                                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                        </svg>
                                        Confirm Reservation
                                    </button>
                                @endif
                                
                                @if($reservation->status !== 'cancelled')
                                    <button wire:click="cancelReservation({{ $reservation->id }})"
                                            wire:confirm="Are you sure you want to cancel this reservation?"
                                            class="w-full bg-red-600 hover:bg-red-700 text-white font-bold py-3 px-4 rounded-md transition duration-200 flex items-center justify-center">
                                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                        </svg>
                                        Cancel Reservation
                                    </button>
                                @else
                                    <div class="w-full bg-gray-100 text-gray-500 font-medium py-3 px-4 rounded-md text-center">
                                        Reservation Cancelled
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Time until reservation (for future reservations) -->
                        @if($reservation->status !== 'cancelled' && $reservation->reservation_datetime > now())
                            <div class="px-6 py-3 bg-red-50 border-t">
                                <div class="flex items-center text-red-700 text-sm">
                                    <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"></path>
                                    </svg>
                                    {{ $reservation->reservation_datetime->diffForHumans() }}
                                </div>
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            @if($reservations->hasPages())
                <div class="mt-12 bg-white rounded-lg shadow-lg p-6">
                    {{ $reservations->links() }}
                </div>
            @endif
        @else
            <!-- Empty State -->
            <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                <div class="text-center py-16 px-8">
                    <div class="mx-auto h-24 w-24 text-gray-400 mb-6">
                        <svg fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-4">No Reservations Found</h3>
                    <p class="text-xl text-gray-600">No reservations have been made yet.</p>
                </div>
            </div>
        @endif
    </div>
</div>
