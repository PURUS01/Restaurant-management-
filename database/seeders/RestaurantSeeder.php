<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Restaurant;
use App\Models\Table;
use App\Models\Meal;

class RestaurantSeeder extends Seeder
{
    /**
     * Run the database seeder.
     */
    public function run(): void
    {
        // Create restaurant
        $restaurant = Restaurant::create([
            'name' => 'Delicious Restaurant',
            'description' => 'A premium dining experience with exquisite cuisine and elegant atmosphere.',
            'address' => '123 Main Street, City Center',
            'phone' => '+1-555-0123',
            'opening_time' => '09:00:00',
            'closing_time' => '22:00:00',
            'status' => 'open',
        ]);

        // Create tables
        $tables = [
            ['table_number' => '1', 'capacity' => 2, 'location' => 'window'],
            ['table_number' => '2', 'capacity' => 4, 'location' => 'center'],
            ['table_number' => '3', 'capacity' => 6, 'location' => 'corner'],
            ['table_number' => '4', 'capacity' => 2, 'location' => 'window'],
            ['table_number' => '5', 'capacity' => 8, 'location' => 'center'],
            ['table_number' => '6', 'capacity' => 4, 'location' => 'corner'],
        ];

        foreach ($tables as $tableData) {
            Table::create([
                'restaurant_id' => $restaurant->id,
                'table_number' => $tableData['table_number'],
                'capacity' => $tableData['capacity'],
                'status' => 'available',
                'location' => $tableData['location'],
                'x_position' => rand(10, 90) / 10, // Random position for demo
                'y_position' => rand(10, 90) / 10,
            ]);
        }

        // Create meals
        $appetizers = [
            ['name' => 'Crispy Calamari', 'description' => 'Fresh squid rings with marinara sauce', 'price' => 12.99],
            ['name' => 'Caesar Salad', 'description' => 'Romaine lettuce, parmesan cheese, croutons', 'price' => 9.99],
            ['name' => 'Buffalo Wings', 'description' => 'Spicy chicken wings with blue cheese dip', 'price' => 14.99],
        ];

        $mains = [
            ['name' => 'Grilled Salmon', 'description' => 'Atlantic salmon with lemon butter sauce', 'price' => 24.99],
            ['name' => 'Ribeye Steak', 'description' => '12oz ribeye cooked to perfection', 'price' => 32.99],
            ['name' => 'Margherita Pizza', 'description' => 'Fresh mozzarella, tomato sauce, basil', 'price' => 18.99],
            ['name' => 'Chicken Parmesan', 'description' => 'Breaded chicken with pasta sauce', 'price' => 22.99],
            ['name' => 'Vegetarian Pasta', 'description' => 'Penne with seasonal vegetables', 'price' => 16.99],
        ];

        $desserts = [
            ['name' => 'Tiramisu', 'description' => 'Classic Italian dessert with coffee', 'price' => 8.99],
            ['name' => 'Chocolate Cake', 'description' => 'Rich chocolate cake with ganache', 'price' => 7.99],
            ['name' => 'Ice Cream Sundae', 'description' => 'Vanilla ice cream with toppings', 'price' => 6.99],
        ];

        $beverages = [
            ['name' => 'Cappuccino', 'description' => 'Espresso with steamed milk', 'price' => 4.99],
            ['name' => 'Fresh Orange Juice', 'description' => 'Freshly squeezed orange juice', 'price' => 3.99],
            ['name' => 'Coca-Cola', 'description' => 'Classic Coca-Cola', 'price' => 2.99],
            ['name' => 'Sparkling Water', 'description' => 'Imported sparkling water', 'price' => 3.99],
        ];

        $categories = [
            'appetizer' => $appetizers,
            'main_course' => $mains,
            'dessert' => $desserts,
            'beverage' => $beverages,
        ];

        foreach ($categories as $category => $meals) {
            foreach ($meals as $mealData) {
                Meal::create([
                    'restaurant_id' => $restaurant->id,
                    'name' => $mealData['name'],
                    'description' => $mealData['description'],
                    'price' => $mealData['price'],
                    'category' => $category,
                    'image_url' => null,
                    'is_available' => true,
                    'preparation_time' => rand(15, 45), // Random prep времени between 15-45 minutes
                ]);
            }
        }
    }
}