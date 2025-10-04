<x-app-layout>
    <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        <!-- Client Header -->
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Welcome, {{ Auth::user()->name }}!</h1>
            <p class="text-gray-600">Manage your restaurant experience</p>
        </div>

        <!-- Quick Actions -->
        <div class="mb-8">
            <h2 class="text-xl font-bold text-gray-900 mb-4">Quick Actions</h2>
            <div class="flex flex-wrap gap-4">
                <a href="{{ route('bookings.create') }}" 
                   class="bg-orange-500 text-white px-6 py-3 rounded-lg hover:bg-orange-600 transition">
                    Book a Table
                </a>
                <a href="{{ route('orders.draft') }}" 
                   class="bg-blue-500 text-white px-6 py-3 rounded-lg hover:bg-blue-600 transition">
                    Start Order
                </a>
                <a href="{{ route('menu') }}" 
                   class="bg-green-500 text-white px-6 py-3 rounded-lg hover:bg-green-600 transition">
                    View Menu
                </a>
            </div>
        </div>

        <!-- Upcoming Bookings -->
        <div class="mb-8">
            <h2 class="text-xl font-bold text-gray-900 mb-4">Upcoming Bookings</h2>
            @if($upcomingBookings->count() > 0)
                <div class="space-y-4">
                    @foreach($upcomingBookings as $booking)
                        <div class="bg-white shadow rounded-lg p-6">
                            <div class="flex justify-between items-start">
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-900">Table {{ $booking->table->table_number }}</h3>
                                    <p class="text-gray-600">{{ $booking->party_size }} people</p>
                                    <p class="text-sm text-gray-500">{{ $booking->booking_date_time->format('l, M d, Y \a\t H:i') }}</p>
                                    @if($booking->special_requests)
                                        <p class="text-sm text-gray-600 mt-2">
                                            <strong>Special requests:</strong> {{ $booking->special_requests }}
                                        </p>
                                    @endif
                                </div>
                                <div class="text-right">
                                    <span class="px-3 py-1 rounded-full text-sm font-medium
                                        @if($booking->status === 'pending') bg-yellow-100 text-yellow-800
                                        @elseif($booking->status === 'confirmed') bg-green-100 text-green-800
                                        @elseif($booking->status === 'cancelled') bg-red-100 text-red-800
                                        @else bg-gray-100 text-gray-800
                                        @endif">
                                        {{ ucfirst($booking->status) }}
                                    </span>
                                    <div class="mt-2 space-x-2">
                                        <a href="{{ route('bookings.show', $booking) }}" 
                                           class="text-blue-600 hover:text-blue-800 text-sm">View Details</a>
                                        @if($booking->isCancellable())
                                            <form method="POST" action="{{ route('bookings.destroy', $booking) }}" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                        class="text-red-600 hover:text-red-800 text-sm"
                                                        onclick="return confirm('Are you sure you want to cancel this booking?')">
                                                    Cancel
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="bg-white shadow rounded-lg p-8 text-center">
                    <div class="text-gray-400 text-4xl mb-4">📅</div>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">No upcoming bookings</h3>
                    <p class="text-gray-600 mb-4">Book a table to enjoy our delicious food!</p>
                    <a href="{{ route('bookings.create') }}" 
                       class="bg-orange-500 text-white px-6 py-3 rounded-lg hover:bg-orange-600 transition">
                        Book a Table
                    </a>
                </div>
            @endif
        </div>

        <!-- Recent Orders -->
        <div class="mb-8">
            <h2 class="text-xl font-bold text-gray-900 mb-4">Recent Orders</h2>
            @if($recentOrders->count() > 0)
                <div class="space-y-4">
                    @foreach($recentOrders as $order)
                        <div class="bg-white shadow rounded-lg p-6">
                            <div class="flex justify-between items-start">
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-900">Order #{{ $order->id }}</h3>
                                    <p class="text-gray-600">${{ $order->total_amount }}</p>
                                    <p class="text-sm text-gray-500">{{ $order->created_at->format('M d, Y H:i') }}</p>
                                    @if($order->table)
                                        <p class="text-sm text-gray-600">Table {{ $order->table->table_number }}</p>
                                    @endif
                                    @if($order->special_instructions)
                                        <p class="text-sm text-gray-600 mt-2">
                                            <strong>Instructions:</strong> {{ $order->special_instructions }}
                                        </p>
                                    @endif
                                </div>
                                <div class="text-right">
                                    <span class="px-3 py-1 rounded-full text-sm font-medium
                                        @if($order->status === 'pending') bg-yellow-100 text-yellow-800
                                        @elseif($order->status === 'preparing') bg-blue-100 text-blue-800
                                        @elseif($order->status === 'ready') bg-green-100 text-green-800
                                        @elseif($order->status === 'served') bg-purple-100 text-purple-800
                                        @elseif($order->status === 'completed') bg-gray-100 text-gray-800
                                        @elseif($order->status === 'cancelled') bg-red-100 text-red-800
                                        @else bg-gray-100 text-gray-800
                                        @endif">
                                        {{ ucfirst($order->status) }}
                                    </span>
                                    @if($order->canBeCancelled())
                                        <div class="mt-2">
                                            <form method="POST" action="{{ route('orders.destroy', $order) }}" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                        class="text-red-600 hover:text-red-800 text-sm"
                                                        onclick="return confirm('Are you sure you want to cancel this order?')">
                                                    Cancel Order
                                                </button>
                                            </form>
                                        </div>
                                    @endif
                                </div>
                            </div>
                            
                            <!-- Order Items -->
                            @if($order->orderItems->count() > 0)
                                <div class="mt-4 pt-4 border-t border-gray-200">
                                    <h4 class="text-sm font-medium text-gray-900 mb-2">Items:</h4>
                                    <div class="space-y-1">
                                        @foreach($order->orderItems as $item)
                                            <div class="flex justify-between text-sm">
                                                <span>{{ $item->quantity }}x {{ $item->meal->name }}</span>
                                                <span>${{ $item->total_price }}</span>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            @else
                <div class="bg-white shadow rounded-lg p-8 text-center">
                    <div class="text-gray-400 text-4xl mb-4">🍽️</div>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">No recent orders</h3>
                    <p class="text-gray-600 mb-4">Start ordering from our delicious menu!</p>
                    <a href="{{ route('orders.draft') }}" 
                       class="bg-blue-500 text-white px-6 py-3 rounded-lg hover:bg-blue-600 transition">
                        Start Order
                    </a>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
