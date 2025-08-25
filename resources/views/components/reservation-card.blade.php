@props([
    'reservation',
    'showCustomerInfo' => false,
    'iconColor' => 'amber',
    'timeColor' => 'amber'
])

@php
    $iconColorClass = match($iconColor) {
        'red' => 'text-red-600',
        'amber' => 'text-amber-600',
        'blue' => 'text-blue-600',
        'green' => 'text-green-600',
        default => 'text-gray-600'
    };
    
    $timeColorClass = match($timeColor) {
        'red' => 'bg-red-50 text-red-700',
        'amber' => 'bg-amber-50 text-amber-700',
        'blue' => 'bg-blue-50 text-blue-700',
        'green' => 'bg-green-50 text-green-700',
        default => 'bg-gray-50 text-gray-700'
    };
@endphp

<div class="bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 flex flex-col h-full">
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
            <div class="text-white text-sm font-medium">
                #{{ $reservation->id }}
            </div>
        </div>
    </div>

    <!-- Reservation Details -->
    <div class="p-6 flex-grow flex flex-col justify-between">
        <div class="space-y-4">
            @if($showCustomerInfo)
                <!-- Customer Info (Admin View) -->
                <div class="mb-4">
                    <div class="flex items-center text-gray-700 mb-2">
                        <svg class="w-5 h-5 mr-3 {{ $iconColorClass }}" fill="currentColor" viewBox="0 0 20 20">
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
            @endif

            <!-- Date and Time -->
            <div class="mb-4">
                <div class="flex items-center text-gray-700 mb-2">
                    <svg class="w-5 h-5 mr-3 {{ $iconColorClass }}" fill="currentColor" viewBox="0 0 20 20">
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
                    <svg class="w-5 h-5 mr-3 {{ $iconColorClass }}" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zM14 9a1 1 0 00-1 1v6a1 1 0 001 1h2a1 1 0 001-1v-6a1 1 0 00-1-1h-2z"></path>
                    </svg>
                    <div>
                        <div class="text-sm text-gray-500">Table</div>
                        <div class="font-semibold">{{ $reservation->table->name ?? 'N/A' }}</div>
                    </div>
                </div>
                <div class="flex items-center text-gray-700">
                    <svg class="w-5 h-5 mr-3 {{ $iconColorClass }}" fill="currentColor" viewBox="0 0 20 20">
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
        </div>

        <!-- Actions Slot -->
        <div class="mt-6">
            {{ $slot }}
        </div>
    </div>

    <!-- Time until reservation (for future reservations) -->
    @if($reservation->status !== 'cancelled' && $reservation->reservation_datetime > now())
        <div class="px-6 py-3 {{ $timeColorClass }} border-t">
            <div class="flex items-center text-sm">
                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"></path>
                </svg>
                {{ $reservation->reservation_datetime->diffForHumans() }}
            </div>
        </div>
    @endif
</div>
