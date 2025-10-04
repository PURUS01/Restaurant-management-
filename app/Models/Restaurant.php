<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Restaurant extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'address',
        'phone',
        'opening_time',
        'closing_time',
        'status',
    ];

    protected $casts = [
        'opening_time' => 'datetime',
        'closing_time' => 'datetime',
    ];

    /**
     * Get tables for this restaurant
     */
    public function tables()
    {
        return $this->hasMany(Table::class);
    }

    /**
     * Get meals for this restaurant
     */
    public function meals()
    {
        return $this->hasMany(Meal::class);
    }

    /**
     * Get bookings for this restaurant
     */
    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    /**
     * Get orders for this restaurant
     */
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    /**
     * Get available tables
     */
    public function availableTables()
    {
        return $this->tables()->where('status', 'available');
    }
}