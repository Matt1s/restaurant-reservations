<div class="min-h-screen bg-gray-50">
    <!-- Header Section -->
    <div class="bg-gradient-to-r from-amber-600 to-amber-700 text-white">
        <div class="max-w-7xl mx-auto px-4 py-16">
            <div class="text-center">
                <h1 class="text-4xl font-bold mb-4">My Reservations</h1>
                <p class="text-xl text-amber-100">Manage your dining experiences at SIMPLEE Restaurant</p>
            </div>
        </div>
    </div>

    <!-- Content Section -->
    <div class="max-w-7xl mx-auto px-4 py-12">
        @if ($reservations->count() > 0)
            <!-- Reservations Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6 lg:gap-8">
                @foreach ($reservations as $reservation)
                    <div
                        class="bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition-shadow duration-300 transform flex flex-col h-full">
                        <!-- Status Header -->
                        <div
                            class="px-6 py-4 
                            @if ($reservation->status === 'confirmed') bg-green-500
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
                        <div class="p-6 flex-grow flex flex-col justify-between">
                            <div class="space-y-4">
                                <!-- Date and Time -->
                                <div class="mb-4">
                                    <div class="flex items-center text-gray-700 mb-2">
                                        <svg class="w-5 h-5 mr-3 text-amber-600" fill="currentColor"
                                            viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z"
                                                clip-rule="evenodd"></path>
                                        </svg>
                                        <div>
                                            <div class="font-semibold text-lg text-gray-900">
                                                {{ $reservation->reservation_datetime->format('M d, Y') }}
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
                                        <svg class="w-5 h-5 mr-3 text-amber-600" fill="currentColor"
                                            viewBox="0 0 20 20">
                                            <path
                                                d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zM14 9a1 1 0 00-1 1v6a1 1 0 001 1h2a1 1 0 001-1v-6a1 1 0 00-1-1h-2z">
                                            </path>
                                        </svg>
                                        <div>
                                            <div class="text-sm text-gray-500">Table</div>
                                            <div class="font-semibold">{{ $reservation->table->name }}</div>
                                        </div>
                                    </div>
                                    <div class="flex items-center text-gray-700">
                                        <svg class="w-5 h-5 mr-3 text-amber-600" fill="currentColor"
                                            viewBox="0 0 20 20">
                                            <path
                                                d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z">
                                            </path>
                                        </svg>
                                        <div>
                                            <div class="text-sm text-gray-500">Party Size</div>
                                            <div class="font-semibold">{{ $reservation->party_size }}
                                                {{ $reservation->party_size == 1 ? 'person' : 'people' }}</div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Special Requests -->
                                @if ($reservation->special_requests)
                                    <div class="mb-4 p-3 bg-gray-50 rounded-md">
                                        <div class="text-sm text-gray-500 mb-1">Special Requests</div>
                                        <div class="text-gray-700">{{ $reservation->special_requests }}</div>
                                    </div>
                                @endif
                            </div>

                            <!-- Actions -->
                            <div class="mt-6">
                                @if ($reservation->canBeCancelled())
                                    <button wire:click="cancelReservation({{ $reservation->id }})"
                                        onclick="return confirm('Are you sure you want to cancel this reservation?')"
                                        class="w-full bg-red-600 hover:bg-red-700 text-white font-bold py-3 px-4 rounded-md transition duration-200 flex items-center justify-center">
                                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                                clip-rule="evenodd"></path>
                                        </svg>
                                        Cancel Reservation
                                    </button>
                                @else
                                    <div
                                        class="w-full bg-gray-100 text-gray-500 font-medium py-3 px-4 rounded-md text-center">
                                        @if ($reservation->status === 'cancelled')
                                            Reservation Cancelled
                                        @elseif($reservation->status === 'completed')
                                            Reservation Completed
                                        @else
                                            Cannot be cancelled
                                        @endif
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Time until reservation (for future reservations) -->
                        @if ($reservation->status !== 'cancelled' && $reservation->reservation_datetime > now())
                            <div class="px-6 py-3 bg-amber-50 border-t">
                                <div class="flex items-center text-amber-700 text-sm">
                                    <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                    {{ $reservation->reservation_datetime->diffForHumans() }}
                                </div>
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>

            <!-- Summary Stats -->
            <div class="mt-12 bg-white rounded-lg shadow-lg p-8">
                <h3 class="text-2xl font-bold text-gray-900 mb-6 text-center">Reservation Summary</h3>
                <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                    <div class="text-center">
                        <div class="text-3xl font-bold text-amber-600">{{ $reservations->count() }}</div>
                        <div class="text-gray-600">Total Reservations</div>
                    </div>
                    <div class="text-center">
                        <div class="text-3xl font-bold text-yellow-600">
                            {{ $reservations->where('status', 'pending')->count() }}</div>
                        <div class="text-gray-600">Pending</div>
                    </div>
                    <div class="text-center">
                        <div class="text-3xl font-bold text-green-600">
                            {{ $reservations->where('status', 'confirmed')->count() }}</div>
                        <div class="text-gray-600">Confirmed</div>
                    </div>
                    <div class="text-center">
                        <div class="text-3xl font-bold text-red-600">
                            {{ $reservations->where('status', 'cancelled')->count() }}</div>
                        <div class="text-gray-600">Cancelled</div>
                    </div>
                </div>
            </div>
        @else
            <!-- Empty State -->
            <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                <div class="text-center py-16 px-8">
                    <div class="mx-auto h-24 w-24 text-gray-400 mb-6">
                        <svg fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z"
                                clip-rule="evenodd"></path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-4">No Reservations Yet</h3>
                    <p class="text-xl text-gray-600 mb-8">Ready to experience culinary excellence? Make your first
                        reservation today!</p>
                    <a href="/reservation"
                        class="inline-flex items-center bg-amber-600 hover:bg-amber-700 text-white font-bold py-4 px-8 rounded-lg text-lg transition duration-200">
                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z"
                                clip-rule="evenodd"></path>
                        </svg>
                        Make Your First Reservation
                    </a>
                </div>
            </div>
        @endif

        <!-- Call to Action -->
        @if ($reservations->count() > 0)
            <div class="mt-12 bg-gradient-to-r from-gray-900 to-gray-800 text-white rounded-lg p-8 text-center">
                <h3 class="text-2xl font-bold mb-4">Want to Make Another Reservation?</h3>
                <p class="text-gray-300 mb-6">Experience more of our signature dishes and exceptional service</p>
                <a href="/reservation"
                    class="inline-flex items-center bg-amber-600 hover:bg-amber-700 text-white font-bold py-3 px-6 rounded-lg transition duration-200">
                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z"
                            clip-rule="evenodd"></path>
                    </svg>
                    Make New Reservation
                </a>
            </div>
        @endif
    </div>
</div>
