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
            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6 lg:gap-8">
                @foreach($reservations as $reservation)
                    <x-reservation-card 
                        :reservation="$reservation" 
                        :show-customer-info="true" 
                        icon-color="red" 
                        time-color="red">
                        <!-- Admin Actions -->
                        <div class="space-y-2">
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
                    </x-reservation-card>
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
