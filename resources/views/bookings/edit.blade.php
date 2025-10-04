<x-app-layout>
    <div class="max-w-3xl mx-auto py-6 sm:px-6 lg:px-8">
        <!-- Back Button -->
        <div class="mb-6">
            <a href="{{ route('bookings.show', $booking) }}" 
               class="inline-flex items-center text-orange-600 hover:text-orange-900">
                <svg class="mr-2 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
                Back to Booking
            </a>
        </div>

        <div class="mt-10 sm:mt-0">
            <div class="md:grid md:grid-cols-3 md:gap-6">
                <div class="md:col-span-1">
                    <div class="px-4 sm:px-0">
                        <h3 class="text-lg font-medium leading-6 text-gray-900">Edit Booking</h3>
                        <p class="mt-1 text-sm text-gray-600">
                            Update your table reservation details.
                        </p>
                        <div class="mt-4">
                            <div class="bg-yellow-50 border border-yellow-200 rounded-md p-4">
                                <div class="flex">
                                    <svg class="h-5 w-5 text-yellow-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                    </svg>
                                    <div class="ml-3">
                                        <h3 class="text-sm font-medium text-yellow-800">
                                            Booking Limitations
                                        </h3>
                                        <div class="mt-2 text-sm text-yellow-700">
                                            <p>• You can only edit booking details up to 2 hours before the reservation</p>
                                            <p>• Changes may require admin approval</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mt-5 md:mt-0 md:col-span-2">
                    <form action="{{ route('bookings.update', $booking) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="shadow overflow-hidden sm:rounded-md">
                            <div class="px-4 py-5 bg-white sm:p-6">
                                <div>
                                    <!-- Current Booking Info Display -->
                                    <div class="mb-6 p-4 bg-gray-50 rounded-md">
                                        <h4 class="text-sm font-medium text-gray-900 mb-2">Current Booking</h4>
                                        <div class="grid grid-cols-2 gap-4 text-sm">
                                            <div>
                                                <span class="text-gray-500">Table:</span>
                                                <span class="font-medium">Table {{ $booking->table->table_number }}</span>
                                            </div>
                                            <div>
                                                <span class="text-gray-500">Current Date:</span>
                                                <span class="font-medium">{{ $booking->booking_date_time->format('M j, Y') }}</span>
                                            </div>
                                            <div>
                                                <span class="text-gray-500">Current Time:</span>
                                                <span class="font-medium">{{ $booking->booking_date_time->format('H:i') }}</span>
                                            </div>
                                            <div>
                                                <span class="text-gray-500">Party Size:</span>
                                                <span class="font-medium">{{ $booking->party_size }}</span>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- New Booking Details -->
                                    <div class="grid grid-cols-6 gap-6">
                                        <!-- Booking Date -->
                                        <div class="col-span-6 sm:col-span-3">
                                            <label for="booking_date" class="block text-sm font-medium text-gray-700">New Date</label>
                                            <input type="date" name="booking_date" id="booking_date"
                                                   class="mt-1 focus:ring-orange-500 focus:border-orange-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                                                   min="{{ date('Y-m-d') }}"
                                                   value="{{ $booking->booking_date_time->format('Y-m-d') }}">
                                            @error('booking_date')
                                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <!-- Booking Time -->
                                        <div class="col-span-6 sm:col-span-3">
                                            <label for="booking_time" class="block text-sm font-medium text-gray-700">New Time</label>
                                            <input type="time" name="booking_time" id="booking_time"
                                                   class="mt-1 focus:ring-orange-500 focus:border-orange-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                                                   value="{{ $booking->booking_date_time->format('H:i') }}">
                                            @error('booking_time')
                                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <!-- Party Size -->
                                        <div class="col-span-6 sm:col-span-3">
                                            <label for="party_size" class="block text-sm font-medium text-gray-700">Party Size</label>
                                            <input type="number" name="party_size" id="party_size" min="1" max="{{ $booking->table->capacity }}"
                                                   class="mt-1 focus:ring-orange-500 focus:border-orange-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                                                   value="{{ $booking->party_size }}">
                                            <p class="mt-1 text-xs text-gray-500">Maximum: {{ $booking->table->capacity }} people</p>
                                            @error('party_size')
                                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <!-- Special Requests -->
                                        <div class="col-span-6">
                                            <label for="special_requests" class="block text-sm font-medium text-gray-700">Special Requests</label>
                                            <textarea name="special_requests" id="special_requests" rows="3" maxlength="500"
                                                      class="mt-1 focus:ring-orange-500 focus:border-orange-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                                                      placeholder="Any dietary restrictions, allergies, special occasions, etc.">{{ $booking->special_requests }}</textarea>
                                            @error('special_requests')
                                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="px-4 py-3 bg-gray-50 text-right sm:px-6 space-x-3">
                                <a href="{{ route('bookings.show', $booking) }}" 
                                   class="inline-flex justify-center py-2 px-4 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:border-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    Cancel
                                </a>
                                <button type="submit"
                                        class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-orange-600 hover:bg-orange-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500">
                                    Update Booking
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const bookingDateInput = document.getElementById('booking_date');
            const bookingTimeInput = document.getElementById('booking_time');
            const partySizeInput = document.getElementById('party_size');
            const tableCapacity = {{ $booking->table->capacity }};

            // Validate party size against table capacity
            partySizeInput.addEventListener('input', function() {
                const partySize = parseInt(this.value);
                if (partySize > tableCapacity) {
                    this.setCustomValidity(`This table can only accommodate ${tableCapacity} people`);
                } else {
                    this.setCustomValidity('');
                }
            });

            // Validate booking time
            function validateBookingTime() {
                const selectedDate = bookingDateInput.value;
                const selectedTime = bookingTimeInput.value;
                
                if (selectedDate === '{{ date('Y-m-d') }}' && selectedTime) {
                    const now = new Date();
                    const selectedDateTime = new Date(`${selectedDate}T${selectedTime}`);
                    
                    if (selectedDateTime < now) {
                        bookingTimeInput.setCustomValidity('Booking time cannot be in the past');
                    } else {
                        bookingTimeInput.setCustomValidity('');
                    }
                }
            }

            bookingDateInput.addEventListener('change', validateBookingTime);
            bookingTimeInput.addEventListener('input', validateBookingTime);
        });
    </script>
</x-app-layout>
