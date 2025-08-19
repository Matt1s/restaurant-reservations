<div class="max-w-4xl mx-auto px-4">
    <div class="bg-white rounded-lg shadow-md p-6">
        <h2 class="text-2xl font-bold mb-6">Make a Reservation</h2>

        <!-- Progress Steps -->
        <div class="mb-8">
            <div class="flex items-center">
                <div class="flex items-center text-blue-600">
                    <div class="rounded-full transition duration-500 ease-in-out h-10 w-10 py-3 border-2 border-blue-600 bg-blue-600 text-white text-xs text-center">1</div>
                    <div class="text-xs font-medium uppercase">Date & Time</div>
                </div>
                <div class="flex-auto border-t-2 transition duration-500 ease-in-out {{ $step >= 2 ? 'border-blue-600' : 'border-gray-300' }}"></div>
                <div class="flex items-center {{ $step >= 2 ? 'text-blue-600' : 'text-gray-500' }}">
                    <div class="rounded-full transition duration-500 ease-in-out h-10 w-10 py-3 border-2 {{ $step >= 2 ? 'border-blue-600 bg-blue-600 text-white' : 'border-gray-300' }} text-xs text-center">2</div>
                    <div class="text-xs font-medium uppercase">Select Table</div>
                </div>
                <div class="flex-auto border-t-2 transition duration-500 ease-in-out {{ $step >= 3 ? 'border-blue-600' : 'border-gray-300' }}"></div>
                <div class="flex items-center {{ $step >= 3 ? 'text-blue-600' : 'text-gray-500' }}">
                    <div class="rounded-full transition duration-500 ease-in-out h-10 w-10 py-3 border-2 {{ $step >= 3 ? 'border-blue-600 bg-blue-600 text-white' : 'border-gray-300' }} text-xs text-center">3</div>
                    <div class="text-xs font-medium uppercase">Confirm</div>
                </div>
            </div>
        </div>

        @if ($errors->has('general'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                {{ $errors->first('general') }}
            </div>
        @endif

        <!-- Step 1: Date & Time Selection -->
        @if ($step === 1)
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label for="reservation_date" class="block text-sm font-medium text-gray-700 mb-2">Date</label>
                    <input type="date" 
                           wire:model.live="reservation_date" 
                           min="{{ now()->format('Y-m-d') }}"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    @error('reservation_date') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label for="reservation_time" class="block text-sm font-medium text-gray-700 mb-2">Time</label>
                    <select wire:model.live="reservation_time" 
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">Select Time</option>
                        @foreach ($time_slots as $slot)
                            <option value="{{ $slot }}">{{ $slot }}</option>
                        @endforeach
                    </select>
                    @error('reservation_time') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label for="party_size" class="block text-sm font-medium text-gray-700 mb-2">Party Size</label>
                    <select wire:model.live="party_size" 
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        @for ($i = 1; $i <= 12; $i++)
                            <option value="{{ $i }}">{{ $i }} {{ $i === 1 ? 'Person' : 'People' }}</option>
                        @endfor
                    </select>
                    @error('party_size') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>
            </div>
        @endif

        <!-- Step 2: Table Selection -->
        @if ($step === 2)
            <div>
                <h3 class="text-lg font-semibold mb-4">Available Tables</h3>
                @if ($available_tables->count() > 0)
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        @foreach ($available_tables as $table)
                            <div class="border border-gray-300 rounded-lg p-4 hover:border-blue-500 cursor-pointer"
                                 wire:click="selectTable({{ $table->id }})">
                                <h4 class="font-semibold text-lg">{{ $table->name }}</h4>
                                <p class="text-gray-600">Capacity: {{ $table->capacity }} people</p>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded">
                        No tables available for {{ $party_size }} people on {{ $reservation_date }} at {{ $reservation_time }}.
                        Please try a different date or time.
                    </div>
                @endif

                <div class="mt-6">
                    <button wire:click="goBack" 
                            class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                        Back
                    </button>
                </div>
            </div>
        @endif

        <!-- Step 3: Confirmation -->
        @if ($step === 3)
            <div>
                <h3 class="text-lg font-semibold mb-4">Confirm Your Reservation</h3>
                
                <div class="bg-gray-50 p-4 rounded-lg mb-4">
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <strong>Date:</strong> {{ Carbon\Carbon::parse($reservation_date)->format('M d, Y') }}
                        </div>
                        <div>
                            <strong>Time:</strong> {{ $reservation_time }}
                        </div>
                        <div>
                            <strong>Party Size:</strong> {{ $party_size }} {{ $party_size === 1 ? 'person' : 'people' }}
                        </div>
                        <div>
                            <strong>Table:</strong> {{ $available_tables->find($selected_table_id)->name ?? '' }}
                        </div>
                    </div>
                </div>

                <div class="mb-4">
                    <label for="special_requests" class="block text-sm font-medium text-gray-700 mb-2">Special Requests (Optional)</label>
                    <textarea wire:model="special_requests" 
                              rows="3" 
                              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                              placeholder="Any special requests or dietary requirements..."></textarea>
                    @error('special_requests') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <div class="flex space-x-4">
                    <button wire:click="goBack" 
                            class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                        Back
                    </button>
                    <button wire:click="makeReservation" 
                            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        Confirm Reservation
                    </button>
                </div>
            </div>
        @endif
    </div>
</div>