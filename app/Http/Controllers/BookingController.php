<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\Table;
use App\Models\Restaurant;
use Carbon\Carbon;

class BookingController extends Controller
{
    public function index()
    {
        $bookings = Booking::with(['table', 'restaurant'])
            ->where('user_id', auth()->id())
            ->latest()
            ->get();

        return view('bookings.index', compact('bookings'));
    }

    public function create()
    {
        $restaurant = Restaurant::first();
        $availableTables = Table::where('status', 'available')->get();
        
        return view('bookings.create', compact('restaurant', 'availableTables'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'table_id' => 'required|exists:tables,id',
            'booking_date' => 'required|date|after:now',
            'booking_time' => 'required',
            'party_size' => 'required|integer|min:1|max:20',
            'customer_name' => 'required|string|max:60',
            'customer_phone' => 'required|string|max:30',
            'special_requests' => 'nullable|string|max:500',
        ]);

        // Create booking datetime
        $bookingDateTime = Carbon::createFromFormat('Y-m-d H:i', 
            $request->booking_date . ' ' . $request->booking_time);

        // Check if table can accommodate party size
        $table = Table::find($request->table_id);
        if (!$table->canAccommodate($request->party_size)) {
            return back()->withErrors(['table_id' => 'This table cannot accommodate your party size.']);
        }

        Booking::create([
            'user_id' => auth()->id(),
            'table_id' => $request->table_id,
            'restaurant_id' => $table->restaurant_id,
            'booking_date_time' => $bookingDateTime,
            'party_size' => $request->party_size,
            'status' => 'pending',
            'special_requests' => $request->special_requests,
            'customer_name' => $request->customer_name,
            'customer_phone' => $request->customer_phone,
            'customer_email' => auth()->user()->email,
        ]);

        return redirect()->route('bookings.index')
            ->with('success', 'Booking request submitted successfully!');
    }

    public function show(Booking $booking)
    {
        // Ensure user can only view their own bookings
        if ($booking->user_id !== auth()->id()) {
            abort(403);
        }

        $booking->load(['table', 'restaurant', 'orders']);
        
        return view('bookings.show', compact('booking'));
    }

    public function edit(Booking $booking)
    {
        // Ensure user can only edit their own bookings
        if ($booking->user_id !== auth()->id() || !$booking->isCancellable()) {
            abort(403);
        }

        $availableTables = Table::where('status', 'available')->get();
        
        return view('bookings.edit', compact('booking', 'availableTables'));
    }

    public function update(Request $request, Booking $booking)
    {
        // Ensure user can only update their own bookings
        if ($booking->user_id !== auth()->id() || !$booking->isCancellable()) {
            abort(403);
        }

        $request->validate([
            'booking_date' => 'nullable|date|after:now',
            'booking_time' => 'nullable',
            'party_size' => 'nullable|integer|min:1|max:20',
            'special_requests' => 'nullable|string|max:500',
        ]);

        $updateData = [];
        
        if ($request->booking_date && $request->booking_time) {
            $updateData['booking_date_time'] = Carbon::createFromFormat('Y-m-d H:i', 
                $request->booking_date . ' ' . $request->booking_time);
        }

        if ($request->party_size) {
            $updateData['party_size'] = $request->party_size;
        }

        if ($request->has('special_requests')) {
            $updateData['special_requests'] = $request->special_requests;
        }

        $booking->update($updateData);

        return redirect()->route('bookings.show', $booking)
            ->with('success', 'Booking updated successfully!');
    }

    public function destroy(Booking $booking)
    {
        // Ensure user can only cancel their own bookings
        if ($booking->user_id !== auth()->id() || !$booking->isCancellable()) {
            abort(403);
        }

        $booking->update(['status' => 'cancelled']);
        
        // Free up the table
        $booking->table->update(['status' => 'available']);

        return redirect()->route('bookings.index')
            ->with('success', 'Booking cancelled successfully!');
    }

    // Admin methods
    public function adminIndex()
    {
        $bookings = Booking::with(['user', 'table', 'restaurant'])
            ->latest()
            ->get();

        return view('admin.bookings.index', compact('bookings'));
    }

    public function adminUpdate(Request $request, Booking $booking)
    {
        $request->validate([
            'status' => 'required|in:pending,confirmed,cancelled,completed',
        ]);

        $booking->update(['status' => $request->status]);

        // Update table status based on booking status
        if ($request->status === 'confirmed') {
            $booking->table->update(['status' => 'reserved']);
        } elseif ($request->status === 'completed') {
            $booking->table->update(['status' => 'available']);
        }

        return back()->with('success', 'Booking status updated!');
    }
}