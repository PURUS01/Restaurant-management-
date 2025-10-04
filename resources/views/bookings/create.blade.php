<x-app-layout>
    <div class="max-w-3xl mx-auto py-6 sm:px-6 lg:px-8">
        <div class="mt-10 sm:mt-0">
            <div class="md:grid md:grid-cols-3 md:gap-6">
                <div class="md:col-span-1">
                    <div class="px-4 sm:px-0">
                        <h3 class="text-lg font-medium leading-6 text-gray-900">Book a Table</h3>
                        <p class="mt-1 text-sm text-gray-600">
                            Reserve your table at {{ $restaurant->name }} for an unforgettable dining experience.
                        </p>
                    </div>
                </div>
                <div class="mt-5 md:mt-0 md:col-span-2">
                    <form action="{{ route('bookings.store') }}" method="POST">
                        @csrf
                        <div class="shadow overflow-hidden sm:rounded-md">
                            <div class="px-4 py-5 bg-white sm:p-6">
                                <div class="grid grid-cols-6 gap-6">
                                    <!-- Table Selection -->
                                    <div class="col-span-6 sm:col-span-3">
                                        <label for="table_id" class="block text-sm font-medium text-gray-700">Table</label>
                                        <select name="table_id" id="table_id" required
                                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-orange-500 focus:border-orange-500">
                                            <option value="">Select a table</option>
                                            @foreach($availableTables as $table)
                                                <option value="{{ $table->id }}" data-capacity="{{ $table->capacity }}">
                                                    Table {{ $table->table_number }} (Seats {{ $table->capacity }}) - {{ ucfirst($table->location) }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('table_id')
                                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- Party Size -->
                                    <div class="col-span-6 sm:col-span-3">
                                        <label for="party_size" class="block text-sm font-medium text-gray-700">Party Size</label>
                                        <input type="number" name="party_size" id="party_size" min="1" max="20" required
                                               class="mt-1 focus:ring-orange-500 focus:border-orange-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                                               value="{{ old('party_size') }}">
                                        @error('party_size')
                                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- Booking Date -->
                                    <div class="col-span-6 sm:col-span-3">
                                        <label for="booking_date" class="block text-sm font-medium text-gray-700">Date</label>
                                        <input type="date" name="booking_date" id="booking_date" required
                                               class="mt-1 focus:ring-orange-500 focus:border-orange-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                                               min="{{ date('Y-m-d') }}"
                                               value="{{ old('booking_date') }}">
                                        @error('booking_date')
                                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- Booking Time -->
                                    <div class="col-span-6 sm:col-span-3">
                                        <label for="booking_time" class="block text-sm font-medium text-gray-700">Time</label>
                                        <input type="time" name="booking_time" id="booking_time" required
                                               class="mt-1 focus:ring-orange-500 focus:border-orange-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                                               value="{{ old('booking_time') }}">
                                        @error('booking_time')
                                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- Customer Name -->
                                    <div class="col-span-6 sm:col-span-3">
                                        <label for="customer_name" class="block text-sm font-medium text-gray-700">Full Name</label>
                                        <input type="text" name="customer_name" id="customer_name" required maxlength="60"
                                               class="mt-1 focus:ring-orange-500 focus:border-orange-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                                               value="{{ old('customer_name', Auth::user()->name) }}">
                                        @error('customer_name')
                                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- Customer Phone -->
                                    <div class="col-span-6 sm:col-span-3">
                                        <label for="customer_phone" class="block text-sm font-medium text-gray-700">Phone Number</label>
                                        <input type="tel" name="customer_phone" id="customer_phone" required maxlength="30"
                                               class="mt-1 focus:ring-orange-500 focus:border-orange-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                                               value="{{ old('customer_phone', Auth::user()->phone) }}">
                                        @error('customer_phone')
                                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- Special Requests -->
                                    <div class="col-span-6">
                                        <label for="special_requests" class="block text-sm font-medium text-gray-700">Special Requests</label>
                                        <textarea name="special_requests" id="special_requests" rows="3" maxlength="500"
                                                  class="mt-1 focus:ring-orange-500 focus:border-orange-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                                                  placeholder="Any dietary restrictions, allergies, special occasions, etc.">{{ old('special_requests') }}</textarea>
                                        @error('special_requests')
                                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                                <button type="submit"
                                        class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-orange-600 hover:bg-orange-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500">
                                    Submit Booking Request
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
            const tableSelect = document.getElementById('table_id');
            const partySizeInput = document.getElementById('party_size');
            const bookingDateInput = document.getElementById('booking_date');
            const bookingTimeInput = document.getElementById('booking_time');

            // Set minimum date to today
            const today = new Date().toISOString().split('T')[0];
            bookingDateInput.min = today;

            // Set default time if not specified
            if (!bookingDateInput.value || bookingDateInput.value < today) {
                bookingDateInput.value = today;
            }

            // Validate party size against table capacity
            function validatePartySize() {
                const selectedTable = tableSelect.options[tableSelect.selectedIndex];
                if (selectedTable && selectedTable.value) {
                    const maxCapacity = parseInt(selectedTable.dataset.capacity);
                    const partySize = parseInt(partySizeInput.value);
                    
                    if (partySize && partySize > maxCapacity) {
                        partySizeInput.setCustomValidity(`This table can only accommodate ${maxCapacity} people`);
                    } else {
                        partySizeInput.setCustomValidity('');
                    }
                }
            }

            tableSelect.addEventListener('change', validatePartySize);
            partySizeInput.addEventListener('input', validatePartySize);

            // Warn about booking times outside restaurant hours
            function validateBookingTime() {
                const selectedDate = bookingDateInput.value;
                const selectedTime = bookingTimeInput.value;
                
                if (selectedDate === today && selectedTime) {
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
