<x-app-layout>
    <div class="max-w-3xl mx-auto py-6 sm:px-6 lg:px-8">
        <!-- Back Button -->
        <div class="mb-6">
            <a href="{{ route('bookings.index') }}" 
               class="inline-flex items-center text-orange-600 hover:text-orange-900">
                <svg class="mr-2 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
                Back to Bookings
            </a>
        </div>

        <!-- Booking Header -->
        <div class="bg-white shadow overflow-hidden sm:rounded-lg">
            <div class="px-4 py-5 sm:px-6">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-lg leading-6 font-medium text-gray-900">
                            Booking Details
                        </h3>
                        <p class="mt-1 max-w-2xl text-sm text-gray-500">
                            Reservation confirmation and information
                        </p>
                    </div>
                    <div class="flex items-center space-x-3">
                        <!-- Status Badge -->
                        <span class="px-3 py-1 rounded-full text-sm font-medium
                            @if($booking->status === 'pending') bg-yellow-100 text-yellow-800
                            @elseif($booking->status === 'confirmed') bg-green-100 text-green-800
                            @elseif($booking->status === 'cancelled') bg-red-100 text-red-800
                            @elseif($booking->status === 'completed') bg-gray-100 text-gray-800
                            @else bg-gray-100 text-gray-800
                            @endif">
                            {{ ucfirst($booking->status) }}
                        </span>
                        
                        <!-- Actions -->
                        @if($booking->isCancellable())
                            <form method="POST" action="{{ route('bookings.destroy', $booking) }}" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        class="bg-red-600 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-red-700"
                                        onclick="return confirm('Are you sure you want to cancel this booking?')">
                                    Cancel Booking
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
            
            <div class="border-t border-gray-200">
                <dl>
                    <!-- Table Information -->
                    <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">Table</dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                            <div class="flex items-center">
                                <div class="h-8 w-8 rounded-full bg-orange-100 flex items-center justify-center mr-3">
                                    <span class="text-orange-600 text-sm font-medium">T{{ $booking->table->table_number }}</span>
                                </div>
                                <div>
                                    <div class="font-medium">Table {{ $booking->table->table_number }}</div>
                                    <div class="text-gray-500 text-sm">{{ $booking->table->capacity }} seats • {{ ucfirst($booking->table->location) }}</div>
                                </div>
                            </div>
                        </dd>
                    </div>
                    
                    <!-- Date & Time -->
                    <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-2xl font-medium text-gray-500">Date & Time</dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                            <div class="text-xl font-semibold">{{ $booking->booking_date_time->format('l, F j, Y') }}</div>
                            <div class="text-lg text-gray-600">{{ $booking->booking_date_time->format('g:i A') }}</div>
                        </dd>
                    </div>
                    
                    <!-- Party Size -->
                    <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">Party Size</dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                            {{ $booking->party_size }} {{ $booking->party_size === 1 ? 'person' : 'people' }}
                        </dd>
                    </div>
                    
                    <!-- Customer Information -->
                    <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">Customer</dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                            <div>{{ $booking->customer_name }}</div>
                            <div class="text-gray-500">{{ $booking->customer_email }}</div>
                            <div class="text-gray-500">{{ $booking->customer_phone }}</div>
                        </dd>
                    </div>
                    
                    <!-- Special Requests -->
                    @if($booking->special_requests)
                    <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">Special Requests</dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                            {{ $booking->special_requests }}
                        </dd>
                    </div>
                    @endif
                    
                    <!-- Restaurant Information -->
                    <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">Restaurant</dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                            <div class="font-medium">{{ $booking->restaurant->name }}</div>
                            <div class="text-gray-500">{{ $booking->restaurant->address }}</div>
                            <div class="text-gray-500">{{ $booking->restaurant->phone }}</div>
                        </dd>
                    </div>
                    
                    <!-- Booking Information -->
                    <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">Booking Information</dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                            <div>Booking ID: #{{ $booking->id }}</div>
                            <div class="text-gray-500">Created: {{ $booking->created_at->format('M j, Y \a\t g:i A') }}</div>
                            @if($booking->updated_at != $booking->created_at)
                                <div class="text-gray-500">Last updated: {{ $booking->updated_at->format('M j, Y \a\t g:i A') }}</div>
                            @endif
                        </dd>
                    </div>
                </dl>
            </div>
        </div>

        <!-- Orders Section -->
        @if($booking->orders->count() > 0)
            <div class="mt-8 bg-white shadow overflow-hidden sm:rounded-lg">
                <div class="px-4 py-5 sm:px-6">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">Orders for this booking</h3>
                    <p class="mt-1 max-w-2xl text-sm text-gray-500">
                        Food orders placed for this table reservation
                    </p>
                </div>
                <div class="border-t border-gray-200 divide-y divide-gray-200">
                    @foreach($booking->orders as $order)
                        <div class="px-4 py-4">
                            <div class="flex items-center justify-between">
                                <div>
                                    <div class="text-sm font-medium text-gray-900">Order #{{ $order->id }}</div>
                                    <div class="text-sm text-gray-500">${{ $order->total_amount }} • {{ ucfirst($order->status) }}</div>
                                </div>
                                <span class="px-3 py-1 rounded-full text-sm font-medium
                                    @if($order->status === 'pending') bg-yellow-100 text-yellow-800
                                    @elseif($order->status === 'preparing') bg-blue-100 text-blue-800
                                    @elseif($order->status === 'ready') bg-green-100 text-green-800
                                    @elseif($order->status === 'completed') bg-gray-100 text-gray-800
                                    @else bg-gray-100 text-gray-800
                                    @endif">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</x-app-layout>
