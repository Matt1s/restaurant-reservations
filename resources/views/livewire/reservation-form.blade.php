<div class="min-h-screen bg-cover bg-center" style="background-image: url('/images/hero-background.jpg');">
    <div class="w-full bg-gradient-to-b lg:bg-gradient-to-r to-[#00000033] from-[#000000cc] min-h-screen py-4 md:py-8">
        <div class="max-w-4xl mx-auto px-4 pb-4">
            <div class="bg-white rounded-xl shadow-2xl overflow-hidden">
                <!-- Header Section -->
                <div class="bg-gradient-to-r from-amber-600 to-amber-800 px-4 md:px-8 py-4 md:py-6">
                    <div class="text-center">
                        <h2 class="text-2xl md:text-3xl font-bold text-white mb-2">Reserve Your Table</h2>
                        <p class="text-amber-100 text-sm md:text-base">Experience culinary excellence at SIMPLEE Restaurant</p>
                    </div>
                </div>

            <div class="p-4 md:p-8">
                <!-- Progress Steps -->
                <div class="mb-6 md:mb-8">
                    <!-- Desktop Layout -->
                    <div class="hidden md:flex items-center justify-center">
                        <!-- Step 1 -->
                        <div class="flex items-center text-amber-600 {{ $step > 1 ? 'cursor-pointer hover:opacity-80' : '' }}" 
                             @if($step > 1) 
                                onclick="if(confirm('Going back will reset your reservation progress. Are you sure you want to continue?')) { @this.call('goToStep', 1) }"
                             @endif>
                            <div class="rounded-full transition duration-500 ease-in-out h-12 w-12 flex items-center justify-center border-2 border-amber-600 bg-amber-600 text-white font-bold">
                                @if($step > 1)
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                    </svg>
                                @else
                                    1
                                @endif
                            </div>
                            <div class="ml-2 text-sm font-medium text-amber-600">Date & Time</div>
                        </div>
                        
                        <div class="flex-auto border-t-2 mx-4 transition duration-500 ease-in-out {{ $step >= 2 ? 'border-amber-600' : 'border-gray-300' }}"></div>
                        
                        <!-- Step 2 -->
                        <div class="flex items-center {{ $step >= 2 ? 'text-amber-600' : 'text-gray-400' }} {{ $step > 2 ? 'cursor-pointer hover:opacity-80' : '' }}"
                             @if($step > 2) 
                                onclick="if(confirm('Going back will reset your table selection and special requests. Are you sure you want to continue?')) { @this.call('goToStep', 2) }"
                             @endif>
                            <div class="rounded-full transition duration-500 ease-in-out h-12 w-12 flex items-center justify-center border-2 {{ $step >= 2 ? 'border-amber-600 bg-amber-600 text-white' : 'border-gray-300' }} font-bold">
                                @if($step > 2)
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                    </svg>
                                @else
                                    2
                                @endif
                            </div>
                            <div class="ml-2 text-sm font-medium">Select Table</div>
                        </div>
                        
                        <div class="flex-auto border-t-2 mx-4 transition duration-500 ease-in-out {{ $step >= 3 ? 'border-amber-600' : 'border-gray-300' }}"></div>
                        
                        <!-- Step 3 -->
                        <div class="flex items-center {{ $step >= 3 ? 'text-amber-600' : 'text-gray-400' }}">
                            <div class="rounded-full transition duration-500 ease-in-out h-12 w-12 flex items-center justify-center border-2 {{ $step >= 3 ? 'border-amber-600 bg-amber-600 text-white' : 'border-gray-300' }} font-bold">3</div>
                            <div class="ml-2 text-sm font-medium">Confirm</div>
                        </div>
                    </div>

                    <!-- Mobile Layout -->
                    <div class="md:hidden space-y-4">
                        <!-- Step 1 -->
                        <div class="flex items-center {{ $step >= 1 ? 'text-amber-600' : 'text-gray-400' }} {{ $step > 1 ? 'cursor-pointer hover:opacity-80' : '' }}" 
                             @if($step > 1) 
                                onclick="if(confirm('Going back will reset your reservation progress. Are you sure you want to continue?')) { @this.call('goToStep', 1) }"
                             @endif>
                            <div class="rounded-full transition duration-500 ease-in-out h-10 w-10 flex items-center justify-center border-2 {{ $step >= 1 ? 'border-amber-600 bg-amber-600 text-white' : 'border-gray-300' }} font-bold text-sm">
                                @if($step > 1)
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                    </svg>
                                @else
                                    1
                                @endif
                            </div>
                            <div class="ml-3 flex-1">
                                <div class="text-sm font-medium">Date & Time Selection</div>
                                @if($step === 1)
                                    <div class="text-xs text-gray-500">Choose your dining preferences</div>
                                @endif
                            </div>
                            @if($step === 1)
                                <div class="text-xs bg-amber-100 text-amber-800 px-2 py-1 rounded">Current</div>
                            @endif
                        </div>

                        <!-- Connecting line -->
                        @if($step >= 2)
                            <div class="ml-5 border-l-2 border-amber-600 h-4"></div>
                        @else
                            <div class="ml-5 border-l-2 border-gray-300 h-4"></div>
                        @endif

                        <!-- Step 2 -->
                        <div class="flex items-center {{ $step >= 2 ? 'text-amber-600' : 'text-gray-400' }} {{ $step > 2 ? 'cursor-pointer hover:opacity-80' : '' }}"
                             @if($step > 2) 
                                onclick="if(confirm('Going back will reset your table selection and special requests. Are you sure you want to continue?')) { @this.call('goToStep', 2) }"
                             @endif>
                            <div class="rounded-full transition duration-500 ease-in-out h-10 w-10 flex items-center justify-center border-2 {{ $step >= 2 ? 'border-amber-600 bg-amber-600 text-white' : 'border-gray-300' }} font-bold text-sm">
                                @if($step > 2)
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                    </svg>
                                @else
                                    2
                                @endif
                            </div>
                            <div class="ml-3 flex-1">
                                <div class="text-sm font-medium">Table Selection</div>
                                @if($step === 2)
                                    <div class="text-xs text-gray-500">Choose your preferred table</div>
                                @endif
                            </div>
                            @if($step === 2)
                                <div class="text-xs bg-amber-100 text-amber-800 px-2 py-1 rounded">Current</div>
                            @endif
                        </div>

                        <!-- Connecting line -->
                        @if($step >= 3)
                            <div class="ml-5 border-l-2 border-amber-600 h-4"></div>
                        @else
                            <div class="ml-5 border-l-2 border-gray-300 h-4"></div>
                        @endif

                        <!-- Step 3 -->
                        <div class="flex items-center {{ $step >= 3 ? 'text-amber-600' : 'text-gray-400' }}">
                            <div class="rounded-full transition duration-500 ease-in-out h-10 w-10 flex items-center justify-center border-2 {{ $step >= 3 ? 'border-amber-600 bg-amber-600 text-white' : 'border-gray-300' }} font-bold text-sm">3</div>
                            <div class="ml-3 flex-1">
                                <div class="text-sm font-medium">Confirmation</div>
                                @if($step === 3)
                                    <div class="text-xs text-gray-500">Review and confirm your reservation</div>
                                @endif
                            </div>
                            @if($step === 3)
                                <div class="text-xs bg-amber-100 text-amber-800 px-2 py-1 rounded">Current</div>
                            @endif
                        </div>
                    </div>
                </div>

                @if ($errors->has('general'))
                    <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded-r-md mb-6">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                            </svg>
                            {{ $errors->first('general') }}
                        </div>
                    </div>
                @endif

                @if(session('url_error'))
                    <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4 rounded-r-md mb-6">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                            </svg>
                            {{ session('url_error') }}
                        </div>
                    </div>
                @endif

                @if($step === 2 && request()->has('date'))
                    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded-r-md mb-6">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            </svg>
                            <div>
                                <strong>Great!</strong> Your reservation details from the homepage have been loaded. 
                                <span class="font-medium">{{ \Carbon\Carbon::parse($reservation_date)->format('F j, Y') }} at {{ \Carbon\Carbon::parse($reservation_time)->format('g:i A') }} for {{ $party_size }} {{ $party_size == 1 ? 'person' : 'people' }}</span>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Step 1: Date & Time Selection -->
                @if ($step === 1)
                    <div class="space-y-6">
                        <div class="text-center mb-6">
                            <h3 class="text-xl md:text-2xl font-semibold text-gray-800 mb-2">When would you like to dine?</h3>
                            <p class="text-sm md:text-base text-gray-600">Select your preferred date, time, and party size</p>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 md:gap-6">
                            <div class="space-y-2">
                                <label for="reservation_date" class="block text-sm font-semibold text-gray-700 mb-2">
                                    <svg class="w-4 h-4 inline mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd" />
                                    </svg>
                                    Date
                                </label>
                                <input type="date" 
                                       wire:model.live="reservation_date" 
                                       min="{{ \Carbon\Carbon::now('Europe/Prague')->format('Y-m-d') }}"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-amber-500 transition duration-200">
                                @error('reservation_date') 
                                    <span class="text-red-500 text-sm flex items-center mt-1">
                                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                        </svg>
                                        {{ $message }}
                                    </span> 
                                @enderror
                            </div>

                            <div class="space-y-2">
                                <label for="reservation_time" class="block text-sm font-semibold text-gray-700 mb-2">
                                    <svg class="w-4 h-4 inline mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd" />
                                    </svg>
                                    Time
                                </label>
                                <select wire:model.live="reservation_time" 
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-amber-500 transition duration-200">
                                    <option value="">Select Time</option>
                                    @foreach ($time_slots as $slot)
                                        <option value="{{ $slot }}">{{ $slot }}</option>
                                    @endforeach
                                </select>
                                @error('reservation_time') 
                                    <span class="text-red-500 text-sm flex items-center mt-1">
                                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                        </svg>
                                        {{ $message }}
                                    </span> 
                                @enderror
                            </div>

                            <div class="space-y-2">
                                <label for="party_size" class="block text-sm font-semibold text-gray-700 mb-2">
                                    <svg class="w-4 h-4 inline mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z" />
                                    </svg>
                                    Party Size
                                </label>
                                <select wire:model.live="party_size" 
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-amber-500 transition duration-200">
                                    @for ($i = 1; $i <= 12; $i++)
                                        <option value="{{ $i }}">{{ $i }} {{ $i === 1 ? 'Person' : 'People' }}</option>
                                    @endfor
                                </select>
                                @error('party_size') 
                                    <span class="text-red-500 text-sm flex items-center mt-1">
                                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                        </svg>
                                        {{ $message }}
                                    </span> 
                                @enderror
                            </div>
                        </div>

                        <!-- Available Tables Info (when time is selected but not all fields filled) -->
                        @if($reservation_date && $reservation_time && !$party_size)
                            <div class="bg-gradient-to-r from-blue-50 to-blue-100 border-l-4 border-blue-400 p-6 rounded-r-lg">
                                <div class="flex items-center">
                                    <svg class="w-6 h-6 text-blue-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                                    </svg>
                                    <div>
                                        <h4 class="text-blue-800 font-semibold">Time Slot Information</h4>
                                        <p class="text-blue-700">
                                            @php
                                                $totalTables = \App\Models\Table::count();
                                                $availableCount = \App\Models\Table::whereDoesntHave('reservations', function($query) {
                                                    $query->where('reservation_date', $this->reservation_date)
                                                          ->where('reservation_time', $this->reservation_time);
                                                })->count();
                                            @endphp
                                            {{ $availableCount }} out of {{ $totalTables }} tables are available on {{ Carbon\Carbon::parse($reservation_date)->format('M d, Y') }} at {{ $reservation_time }}.
                                            Please select your party size to see suitable tables.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        @endif

                        @if($reservation_date && $reservation_time && $party_size)
                            <div class="flex justify-center">
                                <button wire:click="nextStep" 
                                        class="bg-gradient-to-r from-amber-600 to-amber-700 hover:from-amber-700 hover:to-amber-800 text-white font-bold py-2 sm:py-3 px-4 sm:px-8 rounded-lg shadow-lg transform transition duration-200 hover:scale-105 text-sm sm:text-base">
                                    Find Available Tables
                                    <svg class="w-4 h-4 sm:w-5 sm:h-5 ml-1 sm:ml-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                                    </svg>
                                </button>
                            </div>
                        @endif
                    </div>
                @endif

                <!-- Step 2: Table Selection -->
                @if ($step === 2 && $showTables)
                    <div class="space-y-6">
                        <div class="text-center mb-6">
                            <h3 class="text-2xl font-semibold text-gray-800 mb-2">Choose Your Table</h3>
                            <p class="text-gray-600">Select from our available tables for {{ $party_size }} {{ $party_size === 1 ? 'person' : 'people' }} on {{ Carbon\Carbon::parse($reservation_date)->format('M d, Y') }} at {{ $reservation_time }}</p>
                        </div>
                        
                        @if ($available_tables->count() > 0)
                            <div class="pr-2">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    @foreach ($available_tables as $table)
                                        <div class="bg-gradient-to-br from-white to-gray-50 border-2 border-gray-200 rounded-lg p-4 hover:border-amber-500 hover:shadow-md cursor-pointer transition duration-300 {{ $selected_table_id === $table->id ? 'border-amber-500 bg-amber-50 shadow-md' : '' }}"
                                             wire:click="selectTable({{ $table->id }})">
                                            <div class="flex items-center space-x-4">
                                                <div class="bg-amber-100 w-12 h-12 rounded-lg flex items-center justify-center flex-shrink-0">
                                                    <svg class="w-6 h-6 text-amber-600" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zM14 9a1 1 0 00-1 1v6a1 1 0 001 1h2a1 1 0 001-1v-6a1 1 0 00-1-1h-2z" clip-rule="evenodd" />
                                                    </svg>
                                                </div>
                                                <div class="flex-1">
                                                    <h4 class="font-bold text-lg text-gray-800">{{ $table->name }}</h4>
                                                    <p class="text-gray-600 text-sm">Capacity: {{ $table->capacity }} people</p>
                                                </div>
                                                @if($selected_table_id === $table->id)
                                                    <div class="bg-amber-600 text-white p-2 rounded-full flex-shrink-0">
                                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                                        </svg>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @else
                            <div class="bg-yellow-50 border-l-4 border-yellow-400 p-6 rounded-r-lg">
                                <div class="flex items-center">
                                    <svg class="w-6 h-6 text-yellow-400 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                    </svg>
                                    <div>
                                        <h4 class="text-yellow-800 font-semibold">No tables available</h4>
                                        <p class="text-yellow-700">No tables available for {{ $party_size }} people on {{ $reservation_date }} at {{ $reservation_time }}. Please try a different date or time.</p>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <div class="flex flex-col sm:flex-row justify-between gap-3 sm:gap-0">
                            <button wire:click="goBack" 
                                    class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 sm:py-3 px-4 sm:px-6 rounded-lg shadow-md transition duration-200 text-sm sm:text-base">
                                <svg class="w-4 h-4 sm:w-5 sm:h-5 mr-1 sm:mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16l-4-4m0 0l4-4m-4 4h18" />
                                </svg>
                                Back
                            </button>
                            @if($selected_table_id)
                                <button wire:click="nextStep" 
                                        class="bg-gradient-to-r from-amber-600 to-amber-700 hover:from-amber-700 hover:to-amber-800 text-white font-bold py-2 sm:py-3 px-4 sm:px-6 rounded-lg shadow-lg transform transition duration-200 hover:scale-105 text-sm sm:text-base">
                                    Continue
                                    <svg class="w-4 h-4 sm:w-5 sm:h-5 ml-1 sm:ml-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                                    </svg>
                                </button>
                            @endif
                        </div>
                    </div>
                @endif

                <!-- Step 3: Confirmation -->
                @if ($step === 3)
                    <div class="space-y-6">
                        <div class="text-center mb-6">
                            <h3 class="text-2xl font-semibold text-gray-800 mb-2">Confirm Your Reservation</h3>
                            <p class="text-gray-600">Please review your reservation details</p>
                        </div>
                        
                        <div class="bg-gradient-to-br from-amber-50 to-amber-100 p-6 rounded-xl border-2 border-amber-200">
                            <h4 class="text-lg font-semibold text-amber-800 mb-4 flex items-center">
                                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd" />
                                </svg>
                                Reservation Details
                            </h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div class="bg-white p-4 rounded-lg">
                                    <div class="flex items-center mb-2">
                                        <svg class="w-4 h-4 text-amber-600 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd" />
                                        </svg>
                                        <span class="font-semibold text-gray-700">Date:</span>
                                    </div>
                                    <p class="text-gray-800 font-bold">{{ Carbon\Carbon::parse($reservation_date)->format('M d, Y') }}</p>
                                </div>
                                <div class="bg-white p-4 rounded-lg">
                                    <div class="flex items-center mb-2">
                                        <svg class="w-4 h-4 text-amber-600 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd" />
                                        </svg>
                                        <span class="font-semibold text-gray-700">Time:</span>
                                    </div>
                                    <p class="text-gray-800 font-bold">{{ $reservation_time }}</p>
                                </div>
                                <div class="bg-white p-4 rounded-lg">
                                    <div class="flex items-center mb-2">
                                        <svg class="w-4 h-4 text-amber-600 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z" />
                                        </svg>
                                        <span class="font-semibold text-gray-700">Party Size:</span>
                                    </div>
                                    <p class="text-gray-800 font-bold">{{ $party_size }} {{ $party_size === 1 ? 'person' : 'people' }}</p>
                                </div>
                                <div class="bg-white p-4 rounded-lg">
                                    <div class="flex items-center mb-2">
                                        <svg class="w-4 h-4 text-amber-600 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zM14 9a1 1 0 00-1 1v6a1 1 0 001 1h2a1 1 0 001-1v-6a1 1 0 00-1-1h-2z" clip-rule="evenodd" />
                                        </svg>
                                        <span class="font-semibold text-gray-700">Table:</span>
                                    </div>
                                    <p class="text-gray-800 font-bold">
                                        @if($selected_table_id && $available_tables && $available_tables->count() > 0)
                                            {{ $available_tables->where('id', $selected_table_id)->first()->name ?? 'Selected Table' }}
                                        @endif
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="space-y-4">
                            <label for="special_requests" class="block text-sm font-semibold text-gray-700">
                                <svg class="w-4 h-4 inline mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 5v8a2 2 0 01-2 2h-5l-5 4v-4H4a2 2 0 01-2-2V5a2 2 0 012-2h12a2 2 0 012 2zM7 8H5v2h2V8zm2 0h2v2H9V8zm6 0h-2v2h2V8z" clip-rule="evenodd" />
                                </svg>
                                Special Requests (Optional)
                            </label>
                            <textarea wire:model="special_requests" 
                                      rows="4" 
                                      class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-amber-500 transition duration-200"
                                      placeholder="Let us know about any dietary requirements, special occasions, or other requests..."></textarea>
                            @error('special_requests') 
                                <span class="text-red-500 text-sm flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                    </svg>
                                    {{ $message }}
                                </span> 
                            @enderror
                        </div>

                        <div class="flex flex-col sm:flex-row justify-between gap-3 sm:gap-0">
                            <button wire:click="goBack" 
                                    class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 sm:py-3 px-4 sm:px-6 rounded-lg shadow-md transition duration-200 text-sm sm:text-base">
                                <svg class="w-4 h-4 sm:w-5 sm:h-5 mr-1 sm:mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16l-4-4m0 0l4-4m-4 4h18" />
                                </svg>
                                Back
                            </button>
                            <button wire:click="makeReservation" 
                                    class="bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 text-white font-bold py-2 sm:py-3 px-4 sm:px-8 rounded-lg shadow-lg transform transition duration-200 hover:scale-105 text-sm sm:text-base">
                                <svg class="w-4 h-4 sm:w-5 sm:h-5 mr-1 sm:mr-2 inline" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                </svg>
                                Confirm Reservation
                            </button>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>