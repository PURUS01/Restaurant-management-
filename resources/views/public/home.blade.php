<x-public-layout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
        <!-- Hero Section -->
        <div class="bg-gradient-to-r from-orange-500 to-red-500 rounded-lg p-8 mb-8">
            <div class="text-center text-white">
                <h1 class="text-4xl font-bold mb-4">{{ $restaurant->name }}</h1>
                <p class="text-xl mb-6">{{ $restaurant->description }}</p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    @guest
                        <a href="{{ route('login') }}" 
                           class="bg-white text-orange-600 px-6 py-3 rounded-lg font-semibold hover:bg-gray-100 transition">
                            Sign In to Book Table
                        </a>
                    @else
                        <a href="{{ route('bookings.create') }}" 
                           class="bg-white text-orange-600 px-6 py-3 rounded-lg font-semibold hover:bg-gray-100 transition">
                            Book a Table
                        </a>
                    @endguest
                    <a href="{{ route('menu') }}" 
                       class="border-2 border-white text-white px-6 py-3 rounded-lg font-semibold hover:bg-white hover:text-orange-600 transition">
                        View Menu
                    </a>
                </div>
            </div>
        </div>

        <!-- Restaurant Info -->
        <div class="grid md:grid-cols-3 gap-6 mb-12">
            <div class="bg-white rounded-lg p-6 shadow-lg">
                <div class="text-center">
                    <div class="text-3xl text-orange-500 mb-2">📍</div>
                    <h3 class="text-lg font-semibold mb-2">Location</h3>
                    <p class="text-gray-600">{{ $restaurant->address }}</p>
                </div>
            </div>
            
            <div class="bg-white rounded-lg p-6 shadow-lg">
                <div class="text-center">
                    <div class="text-3xl text-orange-500 mb-2">⏰</div>
                    <h3 class="text-lg font-semibold mb-2">Hours</h3>
                    <p class="text-gray-600">
                        {{ date('g:i A', strtotime($restaurant->opening_time)) }} - 
                        {{ date('g:i A', strtotime($restaurant->closing_time)) }}
                    </p>
                </div>
            </div>
            
            <div class="bg-white rounded-lg p-6 shadow-lg">
                <div class="text-center">
                    <div class="text-3xl text-orange-500 mb-2">📞</div>
                    <h3 class="text-lg font-semibold mb-2">Contact</h3>
                    <p class="text-gray-600">{{ $restaurant->phone }}</p>
                </div>
            </div>
        </div>

        <!-- Featured Meals -->
        <div class="mb-12">
            <h2 class="text-3xl font-bold text-center mb-8">Featured Dishes</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($featuredMeals as $meal)
                    <div class="bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition">
                        <div class="h-48 bg-gray-200 flex items-center justify-center">
                            @if($meal->image_url)
                                <img src="{{ $meal->image_url }}" alt="{{ $meal->name }}" class="w-full h-full object-cover">
                            @else
                                <span class="text-orange-500 text-4xl">🍽️</span>
                            @endif
                        </div>
                        <div class="p-6">
                            <h3 class="text-xl font-semibold mb-2">{{ $meal->name }}</h3>
                            <p class="text-gray-600 mb-4">{{ Str::limit($meal->description, 80) }}</p>
                            <div class="flex justify-between items-center">
                                <span class="text-2xl font-bold text-orange-500">${{ $meal->price }}</span>
                                @guest
                                    <a href="{{ route('login') }}" 
                                       class="bg-orange-500 text-white px-4 py-2 rounded hover:bg-orange-600 transition">
                                        Order
                                    </a>
                                @else
                                    <a href="{{ route('orders.draft') }}" 
                                       class="bg-orange-500 text-white px-4 py-2 rounded hover:bg-orange-600 transition">
                                        Order
                                    </a>
                                @endguest
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Call to Action -->
        <div class="text-center mb-8">
            <h2 class="text-3xl font-bold mb-4">Ready to Enjoy Great Food?</h2>
            <p class="text-gray-600 mb-6">Book your table now or browse our full menu</p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                @guest
                    <a href="{{ route('register') }}" 
                       class="bg-orange-500 text-white px-8 py-3 rounded-lg font-semibold hover:bg-orange-600 transition">
                        Sign Up
                    </a>
                @else
                    <a href="{{ route('bookings.create') }}" 
                       class="bg-orange-500 text-white px-8 py-3 rounded-lg font-semibold hover:bg-orange-600 transition">
                        Book Table
                    </a>
                @endguest
                <a href="{{ route('menu') }}" 
                   class="border-2 border-orange-500 text-orange-500 px-8 py-3 rounded-lg font-semibold hover:bg-orange-500 hover:text-white transition">
                    View Full Menu
                </a>
            </div>
        </div>
    </div>
</x-public-layout>
