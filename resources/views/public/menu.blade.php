<x-public-layout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
        <!-- Header -->
        <div class="text-center mb-12">
            <h1 class="text-4xl font-bold text-gray-900 mb-4">Our Menu</h1>
            <p class="text-xl text-gray-600">Discover our delicious offerings</p>
        </div>

        <!-- Menu Categories -->
        @foreach($meals as $category => $categoryMeals)
            <div class="mb-12">
                <h2 class="text-3xl font-bold text-gray-900 mb-8 capitalize border-b-2 border-orange-500 pb-2">
                    {{ ucfirst(str_replace('_', ' ', $category)) }}
                </h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($categoryMeals as $meal)
                        <div class="bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition transform hover:-translate-y-1">
                            <div class="h-48 bg-gray-200 flex items-center justify-center">
                                @if($meal->image_url)
                                    <img src="{{ $meal->image_url }}" alt="{{ $meal->name }}" class="w-full h-full object-cover">
                                @else
                                    @if($category === 'appetizer')
                                        <span class="text-orange-500 text-5xl">🥗</span>
                                    @elseif($category === 'main_course')
                                        <span class="text-orange-500 text-5xl">🍖</span>
                                    @elseif($category === 'dessert')
                                        <span class="text-orange-500 text-5xl">🍰</span>
                                    @elseif($category === 'beverage')
                                        <span class="text-orange-500 text-5xl">🥤</span>
                                    @else
                                        <span class="text-orange-500 text-5xl">🍽️</span>
                                    @endif
                                @endif
                            </div>
                            
                            <div class="p-6">
                                <div class="flex justify-between items-start mb-3">
                                    <h3 class="text-xl font-semibold text-gray-900">{{ $meal->name }}</h3>
                                    <span class="text-2xl font-bold text-orange-500">${{ $meal->price }}</span>
                                </div>
                                
                                <p class="text-gray-600 mb-4">{{ $meal->description }}</p>
                                
                                <div class="flex justify-between items-center">
                                    <div class="text-sm text-gray-500">
                                        @if($meal->preparation_time)
                                            ⏱️ {{ $meal->preparation_time }} min
                                        @endif
                                    </div>
                                    
                                    @guest
                                        <button onclick="alert('Please sign in to place an order')" 
                                                class="bg-orange-500 text-white px-4 py-2 rounded-lg hover:bg-orange-600 transition font-medium">
                                            Order
                                        </button>
                                    @else
                                        <form action="{{ route('orders.add-meal') }}" method="POST" class="inline">
                                            @csrf
                                            <input type="hidden" name="meal_id" value="{{ $meal->id }}">
                                            <input type="hidden" name="quantity" value="1">
                                            <button type="submit" 
                                                    class="bg-orange-500 text-white px-4 py-2 rounded-lg hover:bg-orange-600 transition font-medium">
                                                Add to Order
                                            </button>
                                        </form>
                                    @endguest
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach

        <!-- Bottom CTA -->
        <div class="text-center mt-16 mb-8">
            <h2 class="text-3xl font-bold text-gray-900 mb-4">Ready to Dig In?</h2>
            <p class="text-gray-600 mb-6">Book your table and enjoy our delicious food</p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                @guest
                    <a href="{{ route('login') }}" 
                       class="bg-orange-500 text-white px-8 py-3 rounded-lg font-semibold hover:bg-orange-600 transition">
                        Sign In to Book Table
                    </a>
                @else
                    <a href="{{ route('bookings.create') }}" 
                       class="bg-orange-500 text-white px-8 py-3 rounded-lg font-semibold hover:bg-orange-600 transition">
                        Book a Table
                    </a>
                @endguest
                
                @auth
                    <a href="{{ route('orders.draft') }}" 
                       class="border-2 border-orange-500 text-orange-500 px-8 py-3 rounded-lg font-semibold hover:bg-orange-500 hover:text-white transition">
                        Continue Order
                    </a>
                @endauth
            </div>
        </div>
    </div>
</x-public-layout>
