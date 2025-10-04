<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\Order;
use App\Models\Table;
use App\Models\Meal;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        
        if ($user->isAdmin()) {
            return $this->adminDashboard();
        } else {
            return $this->clientDashboard();
        }
    }

    private function adminDashboard()
    {
        $stats = [
            'pending_bookings' => Booking::where('status', 'pending')->count(),
            'confirmed_bookings' => Booking::where('status', 'confirmed')->count(),
            'pending_orders' => Order::where('status', 'pending')->count(),
            'available_tables' => Table::where('status', 'available')->count(),
            'total_meals' => Meal::count(),
        ];

        $recentBookings = Booking::with(['user', 'table'])
            ->latest()
            ->take(5)
            ->get();

        $recentOrders = Order::with(['user', 'table'])
            ->latest()
            ->take(5)
            ->get();

        return view('dashboard.admin', compact('stats', 'recentBookings', 'recentOrders'));
    }

    private function clientDashboard()
    {
        $userId = auth()->id();
        
        $upcomingBookings = Booking::where('user_id', $userId)
            ->upcoming()
            ->with('table')
            ->get();

        $recentOrders = Order::where('user_id', $userId)
            ->latest()
            ->with('orderItems.meal')
            ->take(5)
            ->get();

        return view('dashboard.client', compact('upcomingBookings', 'recentOrders'));
    }
}