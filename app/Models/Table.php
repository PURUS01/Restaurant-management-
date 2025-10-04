<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Table extends Model
{
    use HasFactory;

    protected $fillable = [
        'restaurant_id',
        'table_number',
        'capacity',
        'status',
        'location',
        'x_position',
        'y_position',
    ];

    protected $casts = [
        'x_position' => 'decimal:2',
        'y_position' => 'decimal:2',
    ];

    /**
     * Get the restaurant that owns the table
     */
    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class);
    }

    /**
     * Get bookings for this table
     */
    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    /**
     * Get orders for this table
     */
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    /**
     * Check if table is available
     */
    public function isAvailable(): bool
    {
        return $this->status === 'available';
    }

    /**
     * Check if table can accommodate party size
     */
    public function canAccommodate(int $partySize): bool
    {
        return $this->capacity >= $partySize && $this->isAvailable();
    }
}