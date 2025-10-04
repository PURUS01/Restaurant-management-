<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'table_id',
        'restaurant_id',
        'booking_date_time',
        'party_size',
        'status',
        'special_requests',
        'customer_name',
        'customer_phone',
        'customer_email',
    ];

    protected $casts = [
        'booking_date_time' => 'datetime',
        'party_size' => 'integer',
    ];

    /**
     * Get the user that made the booking
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the table for this booking
     */
    public function table()
    {
        return $this->belongsTo(Table::class);
    }

    /**
     * Get the restaurant for this booking
     */
    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class);
    }

    /**
     * Get orders associated with this booking
     */
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    /**
     * Check if booking is confirmed
     */
    public function isConfirmed(): bool
    {
        return $this->status === 'confirmed';
    }

    /**
     * Check if booking is cancellable
     */
    public function isCancellable(): bool
    {
        return in_array($this->status, ['pending', 'confirmed']);
    }

    /**
     * Scope for upcoming bookings
     */
    public function scopeUpcoming($query)
    {
        return $query->where('booking_date_time', '>', now())
                     ->whereIn('status', ['pending', 'confirmed']);
    }
}